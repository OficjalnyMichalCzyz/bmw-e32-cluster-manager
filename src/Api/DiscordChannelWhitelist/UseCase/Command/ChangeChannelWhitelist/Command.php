<?php

namespace E32CM\Api\DiscordChannelWhitelist\UseCase\Command\ChangeChannelWhitelist;

use E32CM\Api\SharedKernel\HttpController;

final class Command extends HttpController
{
    private array $whiteList;

    public function __construct(array $whiteList)
    {
        $this->whiteList = $whiteList;
    }

    public function getWhiteList(): array
    {
        return $this->whiteList;
    }
}