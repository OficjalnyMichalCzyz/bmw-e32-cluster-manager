<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord;

use Doctrine\DBAL\Exception;
use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\ApplicationCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\DisplayMessageCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\SkipMessageCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\IdleCommand;
use E32CM\ClusterManager\Main\ClusterApplications\ClusterApplication;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\DiscordConfiguration;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Consumer\MessageConsumer;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Exception\NoMessagesException;
use E32CM\ClusterManager\Main\Configuration\AppConfiguration;
use E32CM\ClusterManager\Output\Output;

class Discord implements ClusterApplication
{
    public const APP_NAME = 'DISCORD';

    public const USING_OUTPUT = 'USING_OUTPUT';
    public const WAITING = 'WAITING';
    public const READY = 'READY';
    public const CONFIGURE = 'CONFIGURE';

    private MessageConsumer $messageConsumer;

    private DiscordConfiguration $configuration;

    private string $currentAppState = self::READY;
    private string $lastKnownOutputState = 'UNKNOWN';
    private bool $showMessagePlaceOnNextDisplay = true;
    private ?string $lastServerContext = null;
    private ?string $lastChannelContext = null;
    private ?string $lastUserContext = null;

    public function __construct(MessageConsumer $messageConsumer, ConfigurationRepository $configurationRepository)
    {
        $this->messageConsumer = $messageConsumer;
        try {
            $this->configuration = $configurationRepository->getUserConfiguration();
        } catch (Exception $e) {
            $this->currentAppState = self::CONFIGURE;
        }
    }

    public function configure(AppConfiguration $configuration): void
    {
        // TODO: Implement configure() method.
    }

    public function processCommand(InputCommand $command): ApplicationCommand
    {
        if ($this() === self::USING_OUTPUT && $command->getCommand() === InputCommand::OK) {
                return SkipMessageCommand::create();
        }

        return IdleCommand::create();
    }

    private function displayNextDiscordMessage(bool $forceDisplay = false): ApplicationCommand
    {
        $message = $this->getMessageFromQueue();

        $outputMessage = $this->formulateFinalMessageToDisplay($message);

        $this->lastChannelContext = $message->getChannel();
        $this->lastServerContext = $message->getServer();
        $this->currentAppState = self::USING_OUTPUT;

        return DisplayMessageCommand::createWithMessageAndScrollSpeed(
            $outputMessage,
            $this->configuration->getScrollSpeed(),
            ($forceDisplay ? DisplayMessageCommand::FORCE_DISPLAY : DisplayMessageCommand::QUEUE_DISPLAY)
        );
    }

    private function formulateFinalMessageToDisplay(Message $message): string
    {
        $changedBetweenPmAndGlobal = false;
        $showServerName = false;
        $showChannelName = false;
        $showUserName = false;

        if (/** Check if switched from priv to global or viceversa */
            ($this->lastServerContext === null && $message->getServer() !== null)
            || ($this->lastServerContext !== null && $message->getServer() === null)) {
            $changedBetweenPmAndGlobal = true;
        } elseif ($message->getServer() !== $this->lastServerContext) {
            $showServerName = true;
        } elseif ($message->getChannel() !== $this->lastChannelContext) {
            $showChannelName = true;
        } elseif ($message->getAuthor() !== $this->lastUserContext) {
            $showUserName = true;
        }

        if ($changedBetweenPmAndGlobal) {
            if ($this->lastServerContext === null) {
                /** From priv to global -> display all */
                /** Server->Channel->User: blabla */
                return sprintf(
                    '%s->%s->%s: %s',
                    $message->getServer(),
                    $message->getChannel(),
                    $message->getAuthor(),
                    $message->getBody()
                );
            }
            /** From global to priv -> display info that its priv */
            /** PM->User: blabla */
            return sprintf('PM->%s: %s', $message->getAuthor(), $message->getBody());
        }

        if ($showServerName) {
            /** Server->Channel->User: blabla */
            return sprintf(
                '%s->%s->%s: %s',
                $message->getServer(),
                $message->getChannel(),
                $message->getAuthor(),
                $message->getBody()
            );
        }

        if ($showChannelName) {
            /** Channel->User: blabla */
            return sprintf('%s->%s: %s', $message->getChannel(), $message->getAuthor(), $message->getBody());
        }

        if ($showUserName) {
            return sprintf('%s: %s', $message->getAuthor(), $message->getBody());
        }

        /** Same sender, same channel(or priv) */
        return sprintf('>%s', $message->getBody());
    }

    private function getMessageFromQueue(): Message
    {
        return $this->messageConsumer->retrieveMessageFromQueue();
    }

    public function tick(string $lastOutputStatus): ApplicationCommand
    {
        if ($this() === self::CONFIGURE) {
            return DisplayMessageCommand::createWithMessageAndScrollSpeed(
                '  NO CONFIG SET ',
                Output::NO_SCROLLING,
                DisplayMessageCommand::FORCE_DISPLAY
            );
        }

        if ($this->lastKnownOutputState !== $lastOutputStatus) {
            $this->lastKnownOutputState = $lastOutputStatus;
            \E32CM\log('==========================================================');
            \E32CM\log('Discord detected that output is ' . $lastOutputStatus . '! (MEM: ' . memory_get_peak_usage() . ')');
        }

        if ($lastOutputStatus === Output::READY) {
            try {
                return $this->displayNextDiscordMessage();
            } catch (NoMessagesException $exception) {

            }
        }

        if ($lastOutputStatus === Output::BUSY) {
            return IdleCommand::create();
        }

        return IdleCommand::create();
    }

    public function __invoke(): string
    {
        return $this->currentAppState;
    }
}