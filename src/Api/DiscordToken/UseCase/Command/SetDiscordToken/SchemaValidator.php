<?php

namespace E32CM\Api\DiscordToken\UseCase\Command\SetDiscordToken;

use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;

class SchemaValidator implements \E32CM\Api\SharedKernel\SchemaValidator\SchemaValidator
{
    public function validate(array $data): void
    {
        if (!isset($data["token"]) || !is_string($data["token"])) {
            throw new InvalidSchemaException();
        }
    }
}