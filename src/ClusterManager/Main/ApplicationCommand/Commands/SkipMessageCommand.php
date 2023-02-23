<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ApplicationCommand\Commands;

class SkipMessageCommand implements ApplicationCommand
{
    public static function create(): self
    {
        return new self();
    }
}
