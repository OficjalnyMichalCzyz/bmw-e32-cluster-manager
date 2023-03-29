<?php

namespace E32CM\Api\DiscordToken\Controllers;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetDiscordToken extends HttpController
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function run(Request $request): Response
    {
        $requestData = $this->extractJsonDataFromRequest($request);
        $configuration = $this->configurationRepository->getUserConfiguration();
        $configuration->setToken($requestData[0]);
        $this->configurationRepository->saveConfiguration($configuration);

        return $this->createOkResponse();
    }
}