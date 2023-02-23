<?php

namespace E32CM\Api\DiscordScrollSpeed\Controllers;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ChangeScrollSpeed extends HttpController
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
        $configuration->setScrollSpeed($requestData[0]);
        $this->configurationRepository->saveConfiguration($configuration);

        return $this->createOkResponse();
    }
}