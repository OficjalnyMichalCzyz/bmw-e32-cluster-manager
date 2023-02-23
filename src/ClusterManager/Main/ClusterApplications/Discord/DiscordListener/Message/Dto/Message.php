<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto;

use DateTimeImmutable;

class Message
{
    private ?int $id;

    private string $body;

    private ?string $server;

    private string $author;

    private ?string $channel;

    private bool $isPrivateMessage;

    private bool $hasAttachment;

    private ?DateTimeImmutable $sendDate;

    public function __construct(
        ?int $id,
        string $body,
        ?string $server,
        string $author,
        ?string $channel,
        bool $isPrivateMessage,
        bool $hasAttachment,
        ?DateTimeImmutable $sendDate
    ) {
        $this->id = $id;
        $this->body = $body;
        $this->server = $server;
        $this->author = $author;
        $this->channel = $channel;
        $this->isPrivateMessage = $isPrivateMessage;
        $this->hasAttachment = $hasAttachment;
        $this->sendDate = $sendDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getServer(): ?string
    {
        return $this->server;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function getSendDate(): ?DateTimeImmutable
    {
        return $this->sendDate;
    }

    public function isPrivateMessage(): bool
    {
        return $this->isPrivateMessage;
    }

    public function hasAttachment(): bool
    {
        return $this->hasAttachment;
    }
}