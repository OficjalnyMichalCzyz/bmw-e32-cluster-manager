<?php

namespace E32CM\Api\DiscordChannelWhitelist;

use E32CM\Api\DiscordChannelWhitelist\UseCase\Command;
use E32CM\Api\DiscordChannelWhitelist\UseCase\Query;
use E32CM\Api\SharedKernel\HttpController;
use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Controller extends HttpController
{
    private Command\ChangeChannelWhitelist\Handler $changeChannelWhitelist;
    private Query\GetChannelWhitelist\Handler $getChannelWhitelist;

    public function __construct(
        Command\ChangeChannelWhitelist\Handler $changeChannelWhitelist,
        Query\GetChannelWhitelist\Handler $getChannelWhitelist
    )    {
        $this->changeChannelWhitelist = $changeChannelWhitelist;
        $this->getChannelWhitelist = $getChannelWhitelist;
    }

    public function changeChannelWhitelist(Request $request): Response
    {
        try {
            $requestData = $this->extractJsonDataFromRequest($request);
        } catch (\JsonException $e) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Malformed JSON");
        }

        $schemaValidator = new Command\ChangeChannelWhitelist\SchemaValidator();
        try {
            $schemaValidator->validate($requestData);
        } catch (InvalidSchemaException $exception) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Invalid request data");
        }

        $this->changeChannelWhitelist->handle(new Command\ChangeChannelWhitelist\Command($requestData));
        return $this->createOkResponse();
    }

    public function getChannelWhitelist(): Response
    {
        try {
            return $this->createResponse(
                200,
                json_encode(
                    $this->getChannelWhitelist->handle()
                )
            );
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }
    }
}