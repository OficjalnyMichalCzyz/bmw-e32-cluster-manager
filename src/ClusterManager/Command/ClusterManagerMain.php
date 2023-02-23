<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Command;


use E32CM\ClusterManager\Main\Main;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClusterManagerMain extends Command
{
    private Main $main;

    public function __construct(
        Main $main,
        string $name = null
    ) {
        parent::__construct($name);
        $this->main = $main;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
        $this->main->setDebugOutput($output);
        $this->main->run();

        $output->writeln('Main closed!');
        return Command::SUCCESS;
    }
}