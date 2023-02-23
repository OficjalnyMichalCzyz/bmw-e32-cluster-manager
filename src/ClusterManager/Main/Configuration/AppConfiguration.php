<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\Configuration;

interface AppConfiguration
{
    public function retrieveConfiguration(): array;
}
