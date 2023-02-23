<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Drivers;

use E32CM\ClusterManager\Input\Mapper\ButtonPress;

interface InputDriver
{
    public function readInput(): ?ButtonPress;
}
