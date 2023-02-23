<?php

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Exception;

use RuntimeException;

class NoMessagesException extends RuntimeException
{
    public static function create(): self
    {
        return new self('No messages in queue!');
    }
}