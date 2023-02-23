<?php

namespace E32CM\Api\DiscordChannelWhitelist\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class HttpController extends AbstractController
{
    /**
     * @param int $responseCode
     * @param string $responseBody
     * @return Response
     */
    protected function createResponse(int $responseCode, string $responseBody): Response
    {
        return new Response($responseBody, $responseCode, ['Content-Type' => 'application/json']);
    }

    /**
     * @return Response
     */
    protected function createNotFoundResponse(): Response
    {
        return new Response("", 404, ['Content-Type' => 'application/json']);
    }

    /**
     * @return Response
     */
    protected function createOkResponse(): Response
    {
        return new Response("", 201, ['Content-Type' => 'application/json']);
    }

    /**
     * @return Response
     */
    protected function createPermissionDeniedResponse(): Response
    {
        return new Response("", 401, ['Content-Type' => 'application/json']);
    }

    /**
     * @return Response
     */
    protected function createForbiddenResponse(): Response
    {
        return new Response("", 403, ['Content-Type' => 'application/json']);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \JsonException
     */
    protected function extractJsonDataFromRequest(Request $request): array
    {
        return json_decode($request->getContent(), true, 4, JSON_THROW_ON_ERROR);
    }

    protected function createJsonResponseBody(\JsonSerializable $serializable): string
    {
        return json_encode($serializable);
    }
}