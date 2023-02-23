<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications;

use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Main\ApplicationCommand\Commands\ApplicationCommand;
use E32CM\ClusterManager\Main\Configuration\AppConfiguration;

interface ClusterApplication
{
    public function configure(AppConfiguration $configuration): void;

    public function processCommand(InputCommand $command): ApplicationCommand;

    public function tick(string $lastOutputStatus): ApplicationCommand;
}
