<?php

namespace E32CM\Api\ButtonMapping\UseCase\Command\AlterButtonMapping;

use E32CM\Api\SharedKernel\HttpController;

final class Command extends HttpController
{
    private array $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function getMapping(): array
    {
        return $this->mapping;
    }
}