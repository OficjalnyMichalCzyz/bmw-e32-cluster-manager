<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper;

use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Input\Mapper\Exception\UnknownButtonException;

class InputMapper
{
    public const BC_STALK_BUTTON = 'BC_STALK_BUTTON';
    public const TELEPHONE_STALK_BUTTON = 'TELEPHONE_STALK_BUTTON';
    public const TELEPHONE_BUTTON = 'TELEPHONE_BUTTON';
    public const RT_BUTTON = 'RT_BUTTON';
    public const PLUS_BUTTON = 'PLUS_BUTTON';
    public const MINUS_BUTTON = 'MINUS_BUTTON';
    public const LEFT_BUTTON = 'LEFT_BUTTON';
    public const RIGHT_BUTTON = 'RIGHT_BUTTON';

    public const POSSIBLE_INPUTS = [
        self::BC_STALK_BUTTON,
        self::TELEPHONE_STALK_BUTTON,
        self::TELEPHONE_BUTTON,
        self::RT_BUTTON,
        self::PLUS_BUTTON,
        self::MINUS_BUTTON,
        self::LEFT_BUTTON,
        self::RIGHT_BUTTON
    ];

    private Mapping $currentMappingSet;

    /**
     * @throws UnknownButtonException
     */
    public function mapButtonToCommand(ButtonPress $button): InputCommand
    {
        if (!isset($this->currentMappingSet)) {
            $this->currentMappingSet = Mapping::getDefaultMapping();
        }

        if ($this->isMapped($button)) {
            $command = $this->currentMappingSet->getButtonToCommandMap()[(string)$button];
            return InputCommand::createWithCommand($command);
        }

        throw UnknownButtonException::createWithUnknownButton($button);
    }

    public function setMapping(Mapping $newMapping): void
    {
        $this->currentMappingSet = $newMapping;
    }

    public static function createWithMapping(Mapping $mapping): self
    {
        $inputMapper = new InputMapper();
        $inputMapper->setMapping($mapping);
        return $inputMapper;
    }

    private function isMapped(ButtonPress $button): bool
    {
        return array_key_exists((string)$button, $this->currentMappingSet->getButtonToCommandMap());
    }
}
