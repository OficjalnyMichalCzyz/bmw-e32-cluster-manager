<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output\Drivers;

class NullDriver implements OutputDriver
{
    public function displayMessage(string $message): void
    {
    }

    public function displaySelectionContext(string $context): void
    {
    }

    public function clearScreen(): void
    {
    }
}
