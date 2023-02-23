<?php

namespace E32CM\Api\DiscordChannelWhitelist\Controllers;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;
use Symfony\Component\HttpFoundation\Response;

final class GetChannelWhitelist extends HttpController
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function run(): Response
    {
        $configuration = $this->configurationRepository->getUserConfiguration();

        $channels = $configuration->getChannelWhitelist();
        return $this->createResponse(
            200,
            json_encode(
                $channels
            )
        );
    }
}