<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Drivers;

use E32CM\ClusterManager\Input\Mapper\ButtonPress;

/**
 * This driver always returns OK
 */
class NullInputDriver implements InputDriver
{
    public function readInput(): ?ButtonPress
    {
        return new ButtonPress('OK');
    }
}
