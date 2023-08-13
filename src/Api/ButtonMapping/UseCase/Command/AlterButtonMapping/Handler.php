<?php

namespace E32CM\Api\ButtonMapping\UseCase\Command\AlterButtonMapping;

use E32CM\Api\SharedKernel\HttpController;
use E32CM\ClusterManager\Input\Mapper\Mapping;
use E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider\MappingProvider;

final class Handler extends HttpController
{
    private MappingProvider $mappingProvider;

    public function __construct(MappingProvider $mappingProvider)
    {
        $this->mappingProvider = $mappingProvider;
    }

    public function handle(Command $command): void
    {
        $mapping = new Mapping($command->getMapping());

        $this->mappingProvider->save($mapping);
    }
}