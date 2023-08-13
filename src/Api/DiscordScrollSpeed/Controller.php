<?php

namespace E32CM\Api\DiscordScrollSpeed;

use E32CM\Api\DiscordScrollSpeed\UseCase\Command;
use E32CM\Api\DiscordScrollSpeed\UseCase\Query;
use E32CM\Api\SharedKernel\HttpController;
use E32CM\Api\SharedKernel\SchemaValidator\Exception\InvalidSchemaException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Controller extends HttpController
{
    private Command\ChangeScrollSpeed\Handler $changeScrollSpeed;
    private Query\GetPossibleScrollSpeeds\Handler $getPossibleScrollSpeeds;
    private Query\GetScrollSpeed\Handler $getScrollSpeed;

    public function __construct(
        Command\ChangeScrollSpeed\Handler $changeScrollSpeed,
        Query\GetPossibleScrollSpeeds\Handler $getPossibleScrollSpeeds,
        Query\GetScrollSpeed\Handler $getScrollSpeed
    )    {
        $this->changeScrollSpeed = $changeScrollSpeed;
        $this->getPossibleScrollSpeeds = $getPossibleScrollSpeeds;
        $this->getScrollSpeed = $getScrollSpeed;
    }

    public function changeScrollSpeed(Request $request): Response
    {
        try {
            $requestData = $this->extractJsonDataFromRequest($request);
        } catch (\JsonException $e) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Malformed JSON");
        }

        $schemaValidator = new Command\ChangeScrollSpeed\SchemaValidator();
        try {
            $schemaValidator->validate($requestData);
        } catch (InvalidSchemaException $exception) {
            return $this->createResponse(Response::HTTP_BAD_REQUEST, "Invalid request data");
        }

        $this->changeScrollSpeed->handle(new Command\ChangeScrollSpeed\Command($requestData["scrollingSpeed"]));
        return $this->createOkResponse();
    }


    public function getPossibleScrollSpeeds(): Response
    {
        try {
            return $this->createResponse(
                200,
                json_encode(
                    $this->getPossibleScrollSpeeds->handle()
                )
            );
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }
    }

    public function getScrollSpeed(): Response
    {
        try {
            return $this->createResponse(
                200,
                json_encode(
                    ['scrollingSpeed' => $this->getScrollSpeed->handle()]
                )
            );
        } catch (\Exception $exception) {
            return $this->createNotFoundResponse();
        }
    }
}