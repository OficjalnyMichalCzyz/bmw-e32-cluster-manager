<?php

namespace E32CM\Api\SharedKernel\SchemaValidator\Exception;

use RuntimeException;

class InvalidSchemaException extends RuntimeException
{
    public static function create(): self
    {
        return new self();
    }
}