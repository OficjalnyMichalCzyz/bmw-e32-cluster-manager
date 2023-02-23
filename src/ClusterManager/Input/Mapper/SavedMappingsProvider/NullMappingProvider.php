<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider;

use E32CM\ClusterManager\Input\Mapper\Mapping;

/**
 * Always returns default mapping
 */
class NullMappingProvider implements MappingProvider
{
    public function retrieveUserSetMapping(): Mapping
    {
        return Mapping::getDefaultMapping();
    }
}
