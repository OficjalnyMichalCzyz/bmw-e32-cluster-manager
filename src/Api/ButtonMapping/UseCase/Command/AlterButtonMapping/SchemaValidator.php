<?php

namespace E32CM\Api\ButtonMapping\UseCase\Command\AlterButtonMapping;

use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;

class SchemaValidator implements \E32CM\Api\SharedKernel\SchemaValidator\SchemaValidator
{
    public function validate(array $data): void
    {
        foreach ($data as $keyBind => $action) {
            if (!is_string($keyBind) || !is_string($action)) {
                throw new InvalidSchemaException();
            }

            if (empty($keyBind) || empty($action)) {
                throw new InvalidSchemaException();
            }
        }

        $uniqueKeybindings = array_unique(array_keys($data));
        if (count($uniqueKeybindings) !== count($data)) {
            throw new InvalidSchemaException();
        }
    }
}