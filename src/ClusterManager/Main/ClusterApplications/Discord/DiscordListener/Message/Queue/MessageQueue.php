<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Queue;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;

interface MessageQueue
{
    public function addToQueue(Message $message): void;
}