<?php

namespace E32CM\Api\DiscordScrollSpeed\UseCase\Command\ChangeScrollSpeed;

final class Command
{
    private string $scrollSpeed;

    public function __construct(string $scrollSpeed)
    {
        $this->scrollSpeed = $scrollSpeed;
    }

    public function getScrollSpeed(): string
    {
        return $this->scrollSpeed;
    }
}