<?php

namespace E32CM\ClusterManager\Main\ApplicationCommand\Commands\Exception;

use LogicException;

class InvalidDisplayModeException extends LogicException
{
    public static function createWithInvalidDisplayMode(string $displayMode): self
    {
        return new self(sprintf('Unknown display mode! Given %s', $displayMode));
    }
}