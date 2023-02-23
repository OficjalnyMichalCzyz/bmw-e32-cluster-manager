<?php

namespace E32CM\Api\DiscordScrollSpeed\Controllers;

use E32CM\ClusterManager\Output\Output;
use Symfony\Component\HttpFoundation\Response;

final class GetPossibleScrollSpeeds extends HttpController
{
    public function run(): Response
    {
        return $this->createResponse(
            200,
            json_encode(
                Output::LIST_OF_SCROLLING_SPEEDS
            )
        );
    }
}