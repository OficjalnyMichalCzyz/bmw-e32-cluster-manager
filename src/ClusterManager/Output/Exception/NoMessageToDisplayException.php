<?php

namespace E32CM\ClusterManager\Output\Exception;

use RuntimeException;

class NoMessageToDisplayException extends RuntimeException
{
    public static function create(): self
    {
        return new self('No message to display!');
    }
}