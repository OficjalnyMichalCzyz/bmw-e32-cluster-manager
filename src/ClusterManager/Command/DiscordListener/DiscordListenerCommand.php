<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Command\DiscordListener;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\Repository as ConfigRepository;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Main;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Queue\MessageQueueBasedOnMysql;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DiscordListenerCommand extends Command
{
    private ConfigRepository $configRepository;
    private MessageQueueBasedOnMysql $messageQueue;

    public function __construct(
        ConfigRepository $configRepository,
        MessageQueueBasedOnMysql $messageQueue,
        string $name = null
    ) {
        parent::__construct($name);
        $this->configRepository = $configRepository;
        $this->messageQueue = $messageQueue;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Started!');
        $main = new Main($this->configRepository, $this->messageQueue);
        $main->run();

        $output->writeln('Closed!');
        return Command::SUCCESS;

    }
}