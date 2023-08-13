<?php

namespace E32CM\Api\DiscordToken;

use E32CM\Api\DiscordToken\UseCase\Command;
use E32CM\Api\DiscordToken\UseCase\Query;
use E32CM\Api\SharedKernel\HttpController;
use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Controller extends HttpController
{
    private Command\SetDiscordToken\Handler $setDiscordToken;
    private Query\GetDiscordToken\Handler $getDiscordToken;

    public function __construct(
        Query\GetDiscordToken\Handler $getDiscordToken,
        Command\SetDiscordToken\Handler $setDiscordToken
    )    {
        $this->getDiscordToken = $getDiscordToken;
        $this->setDiscordToken = $setDiscordToken;
    }

    public function setDiscordToken(Request $request): Response
    {
        try {
            $requestData = $this->extractJsonDataFromRequest($request);
        } catch (\JsonException $e) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Malformed JSON");
        }

        $schemaValidator = new Command\SetDiscordToken\SchemaValidator();
        try {
            $schemaValidator->validate($requestData);
        } catch (InvalidSchemaException $exception) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Invalid request data");
        }

        $this->setDiscordToken->handle(new Command\SetDiscordToken\Command($requestData["token"]));
        return $this->createOkResponse();
    }

    public function getDiscordToken(): Response
    {
        try {
            return $this->createResponse(
                200,
                json_encode(
                    ["token" => $this->getDiscordToken->handle()]
                )
            );
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }
    }
}