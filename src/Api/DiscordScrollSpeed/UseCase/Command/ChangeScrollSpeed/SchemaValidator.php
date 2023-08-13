<?php

namespace E32CM\Api\DiscordScrollSpeed\UseCase\Command\ChangeScrollSpeed;

use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;
use E32CM\ClusterManager\Output\Output;

class SchemaValidator implements \E32CM\Api\SharedKernel\SchemaValidator\SchemaValidator
{
    public function validate(array $data): void
    {
        if (!isset($data['scrollSpeed']) || !is_array($data['scrollSpeed']) || !$this->validateScrollSpeed($data['scrollSpeed'])) {
            throw new InvalidSchemaException();
        }
    }

    public function validateScrollSpeed(array $value): bool
    {
        return in_array($value, Output::LIST_OF_SCROLLING_SPEEDS);
    }
}