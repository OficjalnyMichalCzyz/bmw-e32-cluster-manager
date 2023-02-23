<?php

namespace E32CM\Api\ButtonMapping\Controllers;

use E32CM\ClusterManager\Input\Mapper\Mapping;
use E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider\MappingProviderBasedOnMysql;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AlterButtonMapping extends HttpController
{
    private MappingProviderBasedOnMysql $mappingRepository;

    public function __construct(MappingProviderBasedOnMysql $mappingRepository)
    {
        $this->mappingRepository = $mappingRepository;
    }

    public function run(Request $request): Response
    {
        $requestData = $this->extractJsonDataFromRequest($request);

        $mapping = new Mapping($requestData);

        $this->mappingRepository->save($mapping);

        return $this->createOkResponse();
    }
}