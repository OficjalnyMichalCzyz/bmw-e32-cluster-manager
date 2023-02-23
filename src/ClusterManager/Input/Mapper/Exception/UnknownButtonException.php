<?php

namespace E32CM\ClusterManager\Input\Mapper\Exception;

use E32CM\ClusterManager\Input\Exception\InputException;
use E32CM\ClusterManager\Input\Mapper\ButtonPress;

class UnknownButtonException extends InputException
{
    public static function createWithUnknownButton(ButtonPress $buttonPress): self
    {
        return new self(
            sprintf(
                'Tried to map "%s" button, but there is no mapping for it! Are you sure, you mapped that %s button properly?',
                $buttonPress,
                $buttonPress->getDriverName()
            )
        );
    }
}