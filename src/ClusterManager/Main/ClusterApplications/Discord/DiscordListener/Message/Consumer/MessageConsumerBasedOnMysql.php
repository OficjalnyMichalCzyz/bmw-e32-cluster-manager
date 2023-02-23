<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Consumer;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Dto\Message;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\DiscordListener\Message\Exception\NoMessagesException;

class MessageConsumerBasedOnMysql implements MessageConsumer
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function retrieveMessageFromQueue(): Message
    {
        $message = $this->retrieveOldestMessageFromQueue();
        $this->deleteMessageFromQueue($message);

        return $message;
    }

    private function retrieveOldestMessageFromQueue(): Message
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                SELECT id, body, server, author, sendDate, channel, isPrivateMessage, hasAttachment FROM discord_messages_queue
                    ORDER BY sendDate ASC
                    LIMIT 1;
            ';
        $query = $connection->prepare($sql);
        $result = $query->executeQuery()->fetchAssociative();

        if ($result === false) {
            throw NoMessagesException::create();
        }
        \E32CM\log('Got some message: ' . $result['body']);
        return new Message(
            $result['id'],
            $result['body'],
            $result['server'],
            $result['author'],
            $result['channel'],
            (bool)$result['isPrivateMessage'],
            (bool)$result['hasAttachment'],
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['sendDate'])
        );
    }

    private function deleteMessageFromQueue(Message $message): void
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                DELETE FROM discord_messages_queue 
                    WHERE id = ?;
            ';
        $query = $connection->prepare($sql);
        $query->bindValue(1, $message->getId());
        $query->executeQuery();
        \E32CM\log('Deleted message with id ' . $message->getId());
    }
}