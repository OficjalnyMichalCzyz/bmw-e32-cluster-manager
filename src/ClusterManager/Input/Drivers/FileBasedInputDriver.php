<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Drivers;

use E32CM\ClusterManager\Input\Mapper\ButtonPress;

class FileBasedInputDriver implements InputDriver
{
    public function readInput(): ?ButtonPress
    {
        $fileContent = trim(file_get_contents('VirtualIbus.txt'));

        if (mb_strlen($fileContent) === 0) {
            return null;
        }

        file_put_contents('VirtualIbus.txt', '');

        return new ButtonPress($fileContent, self::class);
    }
}
