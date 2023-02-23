<?php

namespace E32CM\Api\DiscordScrollSpeed\Controllers;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;
use Symfony\Component\HttpFoundation\Response;

final class GetScrollSpeed extends HttpController
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function run(): Response
    {
        $configuration = $this->configurationRepository->getUserConfiguration();

        $scrollSpeed = $configuration->getScrollSpeed();
        return $this->createResponse(
            200,
            json_encode(
                ['scrollingSpeed' => $scrollSpeed]
            )
        );
    }
}