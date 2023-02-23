<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration;

/**
 * Add custom button config for each app?
 */
class DiscordConfiguration implements \JsonSerializable
{
    private string $token;  //MzI3MTM4ODc0OTgxNzQ0NjQw.GwPYT9.oks-lG0-vSAPd2BJ1JYwAMFRE4RdyUYDHc8YpQ
    private ?string $login;
    private ?string $password;
    private array $channelWhitelist;
    private string $scrollSpeed;

    public function __construct(string $token, ?string $login, ?string $password, array $channelWhitelist, string $scrollSpeed)
    {
        $this->token = $token;
        $this->login = $login;
        $this->password = $password;
        $this->channelWhitelist = $channelWhitelist;
        $this->scrollSpeed = $scrollSpeed;
    }

    public function retrieveConfiguration(): array
    {
        return [
            'token' => $this->token,
            'login' => $this->login,
            'password' => $this->password,
            'channelWhitelist' => $this->channelWhitelist,
            'scrollSpeed' => $this->scrollSpeed
        ];
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): DiscordConfiguration
    {
        $this->token = $token;
        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): DiscordConfiguration
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): DiscordConfiguration
    {
        $this->password = $password;
        return $this;
    }

    public function getChannelWhitelist(): array
    {
        return $this->channelWhitelist;
    }

    public function setChannelWhitelist(array $channelWhitelist): DiscordConfiguration
    {
        $this->channelWhitelist = $channelWhitelist;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->retrieveConfiguration();
    }

    public function getScrollSpeed(): string
    {
        return $this->scrollSpeed;
    }

    public function setScrollSpeed(string $scrollSpeed): DiscordConfiguration
    {
        $this->scrollSpeed = $scrollSpeed;
        return $this;
    }
}
