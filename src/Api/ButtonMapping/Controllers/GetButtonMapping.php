<?php

namespace E32CM\Api\ButtonMapping\Controllers;

use E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider\MappingProviderBasedOnMysql;
use Symfony\Component\HttpFoundation\Response;

final class GetButtonMapping extends HttpController
{
    private MappingProviderBasedOnMysql $mappingRepository;

    public function __construct(MappingProviderBasedOnMysql $mappingRepository)
    {
        $this->mappingRepository = $mappingRepository;
    }

    public function run(): Response
    {
        try {
            $configuration = $this->mappingRepository->retrieveUserSetMapping();
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }

        return $this->createResponse(
            200,
            json_encode(
                $configuration->getButtonToCommandMap()
            )
        );
    }
}