<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\DiscordConfiguration;

interface Repository
{
    public function getUserConfiguration(): DiscordConfiguration;

    public function saveConfiguration(DiscordConfiguration $discordConfiguration);
}
