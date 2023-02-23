<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Drivers;

use E32CM\ClusterManager\Input\InputCommand;
use E32CM\ClusterManager\Input\Mapper\ButtonPress;

/**
 * This driver only works on Raspberry Pi with IBUS adapter and stalks connected to system via converter
 */
class BMWStalksAndIBusSteeringWheelButtonsBasedInputDriver implements InputDriver
{
    public function readInput(): ?ButtonPress
    {
        //TODO IMPLEMENT

        //Check for current ibus inputs
        //  return ibus based input

        //If none check for stalks
        //  return stalk based input

        //If both stalks pressed = reset
        return new ButtonPress('OK');
    }
}
