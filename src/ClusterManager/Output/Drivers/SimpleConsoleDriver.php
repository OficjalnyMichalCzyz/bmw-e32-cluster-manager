<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output\Drivers;

class SimpleConsoleDriver implements OutputDriver
{
    public function displayMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function displaySelectionContext(string $context): void
    {
        echo "CONTEXT: " . $context . PHP_EOL;
    }

    public function clearScreen(): void
    {
    }
}
