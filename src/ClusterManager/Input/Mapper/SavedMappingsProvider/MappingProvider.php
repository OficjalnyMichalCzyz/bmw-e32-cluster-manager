<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider;

use E32CM\ClusterManager\Input\Mapper\Mapping;

interface MappingProvider
{
    public function retrieveUserSetMapping(): Mapping;
}
