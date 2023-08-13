<?php

namespace E32CM\Api\SharedKernel\SchemaValidator;

use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;

interface SchemaValidator
{
    /**
     * @throws InvalidSchemaException
     */
    public function validate(array $data): void;
}