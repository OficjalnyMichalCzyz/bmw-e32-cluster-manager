<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Consumer;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;

interface MessageConsumer
{
    public function retrieveMessageFromQueue(): Message;
}