<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input;

class InputCommand
{
    public const LEFT = 'LEFT';
    public const RIGHT = 'RIGHT';
    public const UP = 'UP';
    public const DOWN = 'DOWN';
    public const OK = 'OK';
    public const BACK = 'BACK';
    public const HOME = 'HOME';
    public const INVOKE = 'INVOKE';     //Invoke cluster manager
    public const RESET = 'RESET';  //Requires secret combination

    public const POSSIBLE_COMMANDS = [
        self::LEFT,
        self::RIGHT,
        self::UP,
        self::DOWN,
        self::OK,
        self::BACK,
        self::HOME,
        self::INVOKE,
        self::RESET
    ];

    private string $command;

    private function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public static function createWithCommand(string $command): self
    {
        if (!in_array($command, self::POSSIBLE_COMMANDS)) {
            throw new \Exception("123");
        }

        return new self($command);
    }
}
