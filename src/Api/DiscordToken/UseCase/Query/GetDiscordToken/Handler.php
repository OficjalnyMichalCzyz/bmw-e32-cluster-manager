<?php

namespace E32CM\Api\DiscordToken\UseCase\Query\GetDiscordToken;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;

final class Handler
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function handle(): string
    {
        return $this->configurationRepository->getUserConfiguration()->getToken();
    }
}