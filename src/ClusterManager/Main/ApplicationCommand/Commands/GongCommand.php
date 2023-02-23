<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ApplicationCommand\Commands;

class GongCommand implements ApplicationCommand
{
    private string $tone;

    private int $duration;

    private function __construct(string $tone, int $duration)
    {
        $this->tone = $tone;
        $this->duration = $duration;
    }

    public static function createWithToneAndDuration(string $tone, int $duration): self
    {
        return new self($tone, $duration);
    }

    public function getTone(): string
    {
        return $this->tone;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
