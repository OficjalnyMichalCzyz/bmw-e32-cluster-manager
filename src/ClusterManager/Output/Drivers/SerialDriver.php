<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Output\Drivers;

use PhpSerial;

class SerialDriver implements OutputDriver
{
    private PhpSerial $phpSerial;

    public function __construct()
    {
        $phpSerial = new PhpSerial();
        $phpSerial->deviceSet("COM9");
        $phpSerial->confBaudRate(9600);
        $phpSerial->deviceOpen();
        $this->phpSerial = $phpSerial;
    }

    public function displayMessage(string $message): void
    {
        //str_pad($message, 16
        $this->phpSerial->sendMessage("ABCDEFGHIJ123456", 0);
    }

    public function displaySelectionContext(string $context): void
    {
    }

    public function clearScreen(): void
    {
    }
}
