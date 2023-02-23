<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output\Drivers;

class FileDriver implements OutputDriver
{
    private const MESSAGE_FILE = 'message.txt';
    private const SELECTION_CONTEXT_FILE = 'context.txt';

    public function displayMessage(string $message): void
    {
        file_put_contents(self::MESSAGE_FILE, $message);
    }

    public function displaySelectionContext(string $context): void
    {
        file_put_contents(self::SELECTION_CONTEXT_FILE, $context);
    }

    public function clearScreen(): void
    {
        file_put_contents(self::MESSAGE_FILE, "");
    }
}
