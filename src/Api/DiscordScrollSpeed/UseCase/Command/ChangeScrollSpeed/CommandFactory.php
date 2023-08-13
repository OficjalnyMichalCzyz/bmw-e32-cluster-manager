<?php

namespace E32CM\Api\DiscordScrollSpeed\UseCase\Command\ChangeScrollSpeed;

use E32CM\Api\SharedKernel\HttpController;

final class CommandFactory extends HttpController
{
    private SchemaValidator $schemaValidator;

    public function __construct(SchemaValidator $schemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
    }

    public function create(array $data): Command
    {
        $this->schemaValidator->validate($data);
        return new Command($data["scrollingSpeed"]);
    }
}