<?php

namespace E32CM\Api\DiscordToken\UseCase\Command\SetDiscordToken;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\RepositoryBasedOnMySql as ConfigurationRepository;

final class Handler
{
    private ConfigurationRepository $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function handle(Command $command): void
    {
        $configuration = $this->configurationRepository->getUserConfiguration();
        $configuration->setToken($command->getToken());
        $this->configurationRepository->saveConfiguration($configuration);
    }
}