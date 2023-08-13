<?php

namespace E32CM\Api\ButtonMapping\UseCase\Query\GetButtonMapping;

use E32CM\Api\SharedKernel\HttpController;
use E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider\MappingProvider;

final class Handler extends HttpController
{
    private MappingProvider $mappingProvider;

    public function __construct(MappingProvider $mappingProvider)
    {
        $this->mappingProvider = $mappingProvider;
    }

    public function handle(): array
    {
        return $this->mappingProvider->retrieveUserSetMapping()->getButtonToCommandMap();
    }
}