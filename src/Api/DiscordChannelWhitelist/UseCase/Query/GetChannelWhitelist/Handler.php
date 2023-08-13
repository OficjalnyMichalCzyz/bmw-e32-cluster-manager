<?php

namespace E32CM\Api\DiscordChannelWhitelist\UseCase\Query\GetChannelWhitelist;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;

final class Handler
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function handle(): array
    {
        return $this->configurationRepository->getUserConfiguration()->getChannelWhitelist();
    }
}