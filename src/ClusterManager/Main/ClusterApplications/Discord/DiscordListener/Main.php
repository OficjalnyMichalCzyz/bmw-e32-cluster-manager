<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener;

use Discord\Discord;
use Discord\Parts\Channel\Message as DiscordMessage;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\Repository as ConfigurationProvider;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Queue\MessageQueue;

class Main
{
    private ConfigurationProvider $configurationProvider;

    private MessageQueue $messageQueue;

    private Discord $discord;

    public array $allowedChannels = [608235465639854080, 1071828905322893382];

    public function __construct(
        ConfigurationProvider $configurationProvider,
        MessageQueue $messageQueue
    ) {
        $this->configurationProvider = $configurationProvider;
        $this->messageQueue = $messageQueue;
    }

    public function run()
    {
        $token = $this->configurationProvider->getUserConfiguration()->retrieveConfiguration()['token'];

        $this->discord = new Discord([
            'token' => $token,
            'intents' => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT,
        ]);

        $this->discord->on('ready', function (Discord $discord) {
            $discord->on(Event::MESSAGE_CREATE, function (DiscordMessage $message, Discord $discord) {
                /** no channel = private message */
                $isPrivateMessage = !isset($message->channel);

                if (!$isPrivateMessage) {
                    if (!in_array($message->channel->id, $this->allowedChannels)) {
                        return;
                    }
                }

                /** Add strategy for image/files handling to inform user that SOMETHING was sent? */
                $this->messageQueue->addToQueue(
                    new Message(
                        null,
                        $message->content,
                        $message->guild->name ?? null,
                        $message->author->displayname,
                        $message->channel->name ?? null,
                        $isPrivateMessage,
                        count($message->attachments) !== 0,
                        null
                    )
                );
            });
        });
        $this->discord->run();
    }
}