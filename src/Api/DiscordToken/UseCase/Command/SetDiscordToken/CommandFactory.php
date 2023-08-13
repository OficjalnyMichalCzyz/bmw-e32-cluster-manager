<?php

namespace E32CM\Api\DiscordToken\UseCase\Command\SetDiscordToken;

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
        return new Command($data["token"]);
    }
}