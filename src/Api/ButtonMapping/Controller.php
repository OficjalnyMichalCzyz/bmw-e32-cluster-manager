<?php

namespace E32CM\Api\ButtonMapping;

use E32CM\Api\ButtonMapping\UseCase\Command;
use E32CM\Api\ButtonMapping\UseCase\Query;
use E32CM\Api\SharedKernel\HttpController;
use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Controller extends HttpController
{
    private Command\AlterButtonMapping\Handler $alterButtonMappingHandler;
    private Query\GetButtonMapping\Handler $getButtonMappingHandler;
    private Query\GetPossibleInputsAndCommands\Handler $getPossibleInputsAndCommandsHandler;

    public function __construct(
        Command\AlterButtonMapping\Handler $alterButtonMappingHandler,
        Query\GetButtonMapping\Handler $getButtonMappingHandler,
        Query\GetPossibleInputsAndCommands\Handler $getPossibleInputsAndCommandsHandler
    )    {
        $this->alterButtonMappingHandler = $alterButtonMappingHandler;
        $this->getButtonMappingHandler = $getButtonMappingHandler;
        $this->getPossibleInputsAndCommandsHandler = $getPossibleInputsAndCommandsHandler;
    }

    public function alterButtonMapping(Request $request): Response
    {
        try {
            $requestData = $this->extractJsonDataFromRequest($request);
        } catch (\JsonException $e) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Malformed JSON");
        }

        $schemaValidator = new Command\AlterButtonMapping\SchemaValidator();
        try {
            $schemaValidator->validate($requestData);
        } catch (InvalidSchemaException $exception) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Invalid request data");
        }

        $this->alterButtonMappingHandler->handle(new Command\AlterButtonMapping\Command($requestData));
        return $this->createOkResponse();
    }

    public function getButtonMapping(): Response
    {
        try {
            $buttonMapping = $this->getButtonMappingHandler->handle();
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }

        return $this->createResponse(
            200,
            json_encode(
                $buttonMapping
            )
        );
    }

    public function getPossibleInputsAndCommands(): Response
    {
        return $this->createResponse(
            200,
            json_encode(
                $this->getPossibleInputsAndCommandsHandler->handle()
            )
        );
    }
}