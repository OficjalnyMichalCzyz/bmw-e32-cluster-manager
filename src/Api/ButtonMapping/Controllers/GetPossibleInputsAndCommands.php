<?php

namespace E32CM\Api\ButtonMapping\Controllers;

use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Input\Mapper\InputMapper;
use Symfony\Component\HttpFoundation\Response;

final class GetPossibleInputsAndCommands extends HttpController
{
    public function run(): Response
    {
        return $this->createResponse(
            200,
            json_encode(
                [
                    'commands' => InputCommand::POSSIBLE_COMMANDS,
                    'inputs' => InputMapper::POSSIBLE_INPUTS
                ]
            )
        );
    }
}