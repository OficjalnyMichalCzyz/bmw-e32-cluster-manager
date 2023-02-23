<?php

declare(strict_types=1);

namespace E32CM\ClusterManager\Input\Mapper\SavedMappingsProvider;

use Doctrine\ORM\EntityManagerInterface;
use E32CM\ClusterManager\Input\Mapper\Mapping;

use E32CM\ClusterManager\Main\ClusterApplications\Discord\Discord;

class MappingProviderBasedOnMysql implements MappingProvider
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function retrieveUserSetMapping(): Mapping
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                SELECT id, button_mapping, application, date FROM button_mapping LIMIT 1
            ';
        $query = $connection->prepare($sql);
        $rawResult = $query->executeQuery()->fetchAssociative();
        if ($rawResult === false) {
            throw new \Exception();
        }
        $buttonMapping = json_decode($rawResult['button_mapping'], true);

        return new Mapping($buttonMapping);
    }

    public function save(Mapping $mapping): void
    {
        $this->deleteOldMapping();

        $connection = $this->entityManager->getConnection();
        $sql = 'INSERT INTO `cluster_manager`.`button_mapping` (`button_mapping`, `application`) VALUES (?, ?);';
        $query = $connection->prepare($sql);
        $query->bindValue(1, json_encode($mapping->getButtonToCommandMap()));
        $query->bindValue(2, Discord::APP_NAME);
        $query->executeQuery();
    }

    private function deleteOldMapping(): void
    {
        $connection = $this->entityManager->getConnection();
        $sql =
            '
                DELETE FROM button_mapping 
                    WHERE id = (SELECT id FROM button_mapping ORDER BY date ASC LIMIT 1);
            ';
        $query = $connection->prepare($sql);
        $query->executeQuery();
    }
}
