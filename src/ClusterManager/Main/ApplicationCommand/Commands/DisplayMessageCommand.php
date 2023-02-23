<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ApplicationCommand\Commands;

use E32CM\ClusterManager\Main\ApplicationCommand\Commands\Exception\InvalidDisplayModeException;

class DisplayMessageCommand implements ApplicationCommand
{
    public const LIST_OF_DISPLAY_MODES = [
        self::QUEUE_DISPLAY,
        self::FORCE_DISPLAY
    ];

    public const QUEUE_DISPLAY = 'QUEUE_DISPLAY';
    public const FORCE_DISPLAY = 'FORCE_DISPLAY';

    private string $message;

    private string $scrollSpeed;

    private string $displayMode;

    private function __construct(string $message, string $scrollSpeed, string $displayMode)
    {
        $this->message = $message;
        $this->scrollSpeed = $scrollSpeed;
        $this->displayMode = $displayMode;
    }

    public static function createWithMessageAndScrollSpeed(string $message, string $scrollSpeed, string $displayMode): self
    {
        if (!in_array($displayMode, self::LIST_OF_DISPLAY_MODES)) {
            throw InvalidDisplayModeException::createWithInvalidDisplayMode($displayMode);
        }

        return new self($message, $scrollSpeed, $displayMode);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getScrollSpeed(): string
    {
        return $this->scrollSpeed;
    }

    public function getDisplayMode(): string
    {
        return $this->displayMode;
    }
}
