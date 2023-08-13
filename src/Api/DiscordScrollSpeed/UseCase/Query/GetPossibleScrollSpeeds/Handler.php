<?php

namespace E32CM\Api\DiscordScrollSpeed\UseCase\Query\GetPossibleScrollSpeeds;

use E32CM\ClusterManager\Output\Output;

final class Handler
{
    public function handle(): array
    {
        return Output::LIST_OF_SCROLLING_SPEEDS;
    }
}