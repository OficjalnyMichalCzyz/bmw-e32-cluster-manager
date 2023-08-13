<?php

namespace E32CM\Api\DiscordToken\UseCase\Command\SetDiscordToken;

final class Command
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}