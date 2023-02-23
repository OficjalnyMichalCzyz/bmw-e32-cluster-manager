<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Queue;

use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;

class MessageQueueBasedOnMysql implements MessageQueue
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addToQueue(Message $message): void
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                INSERT INTO discord_messages_queue (`body`, `server`, `author`, `channel`, `isPrivateMessage`, `hasAttachment`) 
                VALUES (?, ?, ?, ?, ?, ?);
            ';
        $query = $connection->prepare($sql);
        $query->bindValue(1, $message->getBody());
        $query->bindValue(2, $message->getServer());
        $query->bindValue(3, $message->getAuthor());
        $query->bindValue(4, $message->getChannel());
        $query->bindValue(5, $message->isPrivateMessage(), ParameterType::INTEGER);
        $query->bindValue(6, $message->hasAttachment(), ParameterType::INTEGER);
        $query->executeQuery();
    }
}

