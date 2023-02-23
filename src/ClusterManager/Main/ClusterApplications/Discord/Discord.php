<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord;

use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\ApplicationCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\DisplayMessageCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\SkipMessageCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\IdleCommand;
use E32CM\ClusterManager\Main\ClusterApplications\ClusterApplication;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Consumer\MessageConsumer;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Exception\NoMessagesException;
use E32CM\ClusterManager\Main\Configuration\AppConfiguration;
use E32CM\ClusterManager\Output\Output;

class Discord implements ClusterApplication
{
    public const APP_NAME = 'DISCORD';

    public const LIST_OF_STATES = [

    ];

    public array $allowedChannels = [608235465639854080, 1071828905322893382];

    public const USING_OUTPUT = 'USING_OUTPUT';
    public const WAITING = 'WAITING';
    public const READY = 'READY';

    private MessageConsumer $messageConsumer;

    private string $currentAppState = self::READY;
    private string $lastKnownOutputState = 'UNKNOWN';
    private bool $showMessagePlaceOnNextDisplay = true;
    private ?string $lastServerContext = null;
    private ?string $lastChannelContext = null;
    private ?string $lastUserContext = null;

    public function __construct(MessageConsumer $messageConsumer)
    {
        $this->messageConsumer = $messageConsumer;
    }

    public function configure(AppConfiguration $configuration): void
    {
        // TODO: Implement configure() method.
    }

    public function processCommand(InputCommand $command): ApplicationCommand
    {
        if ($this() === self::USING_OUTPUT && $command->getCommand() === InputCommand::OK) {
            //Skip current message on screen
        //    try {
      //          return $this->displayNextDiscordMessage();
         //   } catch (NoMessagesException $exception) {
                return SkipMessageCommand::create();
       //     }
        }

        return DisplayMessageCommand::createWithMessageAndScrollSpeed(
            'Idle Idle Idle Idle Idle Idle Idle Idle Idle Idle',
            Output::VERY_SLOW_SCROLLING,
            DisplayMessageCommand::QUEUE_DISPLAY
        );
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
            Output::VERY_FAST_SCROLLING,
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