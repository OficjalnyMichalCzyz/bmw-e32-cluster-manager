<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper;

use E32CM\ClusterManager\Input\InputCommand;

class Mapping
{
    public const DEFAULT_MAP = [
        InputMapper::LEFT_BUTTON => InputCommand::LEFT,
        InputMapper::RIGHT_BUTTON => InputCommand::RIGHT,
        InputMapper::PLUS_BUTTON => InputCommand::UP,
        InputMapper::MINUS_BUTTON => InputCommand::DOWN,
        InputMapper::TELEPHONE_BUTTON => InputCommand::OK,
        InputMapper::RT_BUTTON => InputCommand::BACK,
        InputMapper::TELEPHONE_STALK_BUTTON => InputCommand::INVOKE,
        InputMapper::BC_STALK_BUTTON => InputCommand::HOME
    ];

    private array $buttonToCommandMap;

    public function __construct(array $buttonToCommandMap)
    {
        $this->buttonToCommandMap = $buttonToCommandMap;
    }

    public function getButtonToCommandMap(): array
    {
        return $this->buttonToCommandMap;
    }

    public static function getDefaultMapping(): self
    {
        return new self(self::DEFAULT_MAP);
    }
}