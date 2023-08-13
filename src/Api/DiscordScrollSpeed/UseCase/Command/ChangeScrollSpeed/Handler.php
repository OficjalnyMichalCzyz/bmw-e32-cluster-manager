<?php

namespace E32CM\Api\DiscordScrollSpeed\UseCase\Command\ChangeScrollSpeed;

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
        $configuration->setScrollSpeed($command->getScrollSpeed());
        $this->configurationRepository->saveConfiguration($configuration);
    }
}