<?php

namespace E32CM\ClusterManager\Output\Exception;

use LogicException;

class InvalidScrollModeException extends LogicException
{
    public static function createWithInvalidScrollMode(string $scrollMode): self
    {
        return new self(sprintf('Unknown scroll mode! Given %s', $scrollMode));
    }
}