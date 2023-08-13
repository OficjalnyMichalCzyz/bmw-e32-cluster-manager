<?php

namespace E32CM\Api\DiscordChannelWhitelist\UseCase\Command\ChangeChannelWhitelist;

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
        $configuration->setChannelWhitelist($command->getWhiteList());
        $this->configurationRepository->saveConfiguration($configuration);
    }
}