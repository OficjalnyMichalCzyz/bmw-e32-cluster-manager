<?php

declare(strict_types=1);

namespace E32CM\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230212231725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create button mappings table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE `button_mapping` (
                `id` INT(16) NOT NULL AUTO_INCREMENT,
                `button_mapping` LONGTEXT NOT NULL COLLATE 'utf8mb4_bin',
                `application` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `date` DATETIME NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`) USING BTREE,
                CONSTRAINT `button_mapping` CHECK (json_valid(`button_mapping`))
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB
            ;
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE button_mapping;");
    }
}
