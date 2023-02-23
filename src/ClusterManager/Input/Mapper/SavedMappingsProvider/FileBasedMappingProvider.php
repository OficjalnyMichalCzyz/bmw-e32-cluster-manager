<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider;

use E32CM\ClusterManager\Input\Mapper\Mapping;
use JsonException;

class FileBasedMappingProvider implements MappingProvider
{
    private const USER_SET_MAPPING_FILE = 'mapping.txt';

    public function retrieveUserSetMapping(): Mapping
    {
        $mappingAsJson = file_get_contents(self::USER_SET_MAPPING_FILE);

        try {
            $mapping = json_decode($mappingAsJson, true, 4, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            echo "Invalid mapping json. Exiting"; die(1);
        }

        return new Mapping($mapping);
    }
}
