<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\Repository;

use Doctrine\ORM\EntityManagerInterface;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\Configuration\DiscordConfiguration;
use E32CM\ClusterManager\Main\ClusterApplications\Discord\Discord;

class RepositoryBasedOnMySql implements Repository
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUserConfiguration(): DiscordConfiguration
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                SELECT id, config, application, date FROM application_configuration
                WHERE application = ?
            ';
        $query = $connection->prepare($sql);
        $query->bindValue(1, Discord::APP_NAME);
        $rawResult = $query->executeQuery()->fetchAssociative();

        $config = json_decode($rawResult['config'], true);

        return new DiscordConfiguration(
            $config['token'],
            $config['login'],
            $config['password'],
            $config['channelWhitelist'],
            $config['scrollSpeed'],
        );
    }

    public function saveConfiguration(DiscordConfiguration $discordConfiguration): void
    {
        $this->deleteOldConfiguration();
        $connection = $this->entityManager->getConnection();
        $sql = 'INSERT INTO `cluster_manager`.`application_configuration` (`config`, `application`) VALUES (?, ?);';
        $query = $connection->prepare($sql);
        $query->bindValue(1, json_encode($discordConfiguration));
        $query->bindValue(2, Discord::APP_NAME);
        $query->executeQuery();
    }

    private function deleteOldConfiguration(): void
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                DELETE FROM application_configuration 
                    WHERE application = ?;
            ';
        $query = $connection->prepare($sql);
        $query->bindValue(1, Discord::APP_NAME);
        $query->executeQuery();
    }
}
