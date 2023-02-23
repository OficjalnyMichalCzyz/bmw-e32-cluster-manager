<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Command;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository\Repository as ConfigRepository;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Consumer\MessageConsumerBasedOnMysql;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Queue\MessageQueueBasedOnMysql;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    private ConfigRepository $configRepository;
    private MessageConsumerBasedOnMysql $messageConsumer;
    private MessageQueueBasedOnMysql $messageQueue;

    public function __construct(
        ConfigRepository $configRepository,
        MessageConsumerBasedOnMysql $messageConsumer,
        MessageQueueBasedOnMysql $messageQueue,
        string $name = null
    ) {
        parent::__construct($name);
        $this->configRepository = $configRepository;
        $this->messageConsumer = $messageConsumer;
        $this->messageQueue = $messageQueue;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$message = new Message(null, "𝐏𝐢𝐰𝐧𝐢𝐜𝐚 𝐊𝐚𝐢𝐫𝐨𝐬𝐚", "wwww", "eee", "rrrr", true, true, null);

     //   $this->messageQueue->addToQueue($message);
        //$retrievedMessage = $this->messageConsumer->retrieveMessageFromQueue();
        //var_dump($retrievedMessage);
        //$config = $this->repository->getUserConfiguration();
        //$this->repository->saveConfiguration($config);

        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}