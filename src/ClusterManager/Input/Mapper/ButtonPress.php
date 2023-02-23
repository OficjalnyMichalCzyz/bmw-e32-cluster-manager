<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper;

class ButtonPress
{
    private string $pressedButton;

    private string $driverName;

    public function __construct(string $pressedButton, ?string $driverName)
    {
        $this->pressedButton = $pressedButton;
        $this->driverName = $driverName;
    }

    public function getPressedButton(): string
    {
        return $this->pressedButton;
    }

    public function getDriverName(): string
    {
        return $this->driverName;
    }

    public function __toString()
    {
        return $this->pressedButton;
    }
}