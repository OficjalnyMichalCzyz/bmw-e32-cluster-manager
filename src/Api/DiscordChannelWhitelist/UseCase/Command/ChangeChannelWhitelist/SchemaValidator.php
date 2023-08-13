<?php

namespace E32CM\Api\DiscordChannelWhitelist\UseCase\Command\ChangeChannelWhitelist;

use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;

class SchemaValidator implements \E32CM\Api\SharedKernel\SchemaValidator\SchemaValidator
{
    public function validate(array $data): void
    {
        foreach ($data as $value) {
            if (!is_int($value)) {
                throw new InvalidSchemaException();
            }
        }
    }
}