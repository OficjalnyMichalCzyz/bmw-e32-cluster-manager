<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input;

use E32CM\ClusterManager\Input\Drivers\InputDriver;
use E32CM\ClusterManager\Input\Mapper\InputMapper;
use E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider\MappingProvider;

class Input
{
    private InputDriver $inputDriver;

    private InputMapper $inputMapper;

    private MappingProvider $mappingProvider;

    public function __construct(InputDriver $inputDriver, MappingProvider $mappingProvider)
    {
        $this->inputDriver = $inputDriver;
        $this->mappingProvider = $mappingProvider;
        $this->inputMapper = new InputMapper();
    }

    public function getInputIfAny(): ?InputCommand
    {
        $buttonPress = $this->inputDriver->readInput();

        if ($buttonPress === null) {
            return null;
        }

        return $this->inputMapper->mapButtonToCommand($buttonPress);
    }
}
