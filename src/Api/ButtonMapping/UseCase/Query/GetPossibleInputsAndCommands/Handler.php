<?php

namespace E32CM\Api\ButtonMapping\UseCase\Query\GetPossibleInputsAndCommands;

use E32CM\Api\SharedKernel\HttpController;
use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Input\Mapper\InputMapper;

final class Handler extends HttpController
{
    public function handle(): array
    {
        return [
            'commands' => InputCommand::POSSIBLE_COMMANDS,
            'inputs' => InputMapper::POSSIBLE_INPUTS
        ];
    }
}