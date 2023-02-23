<?php

declare(strict_types=1);

namespace E32CM\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205231725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cluster manager configuration table to store applications configs';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            CREATE TABLE `application_configuration` (
                `id` INT(16) NOT NULL AUTO_INCREMENT,
                `config` LONGTEXT NOT NULL COLLATE 'utf8mb4_bin',
                `application` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                `date` DATETIME NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`) USING BTREE,
                CONSTRAINT `config` CHECK (json_valid(`config`))
            )
            COLLATE='utf8mb4_unicode_ci'
            ENGINE=InnoDB
            ;
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE application_configuration;");
    }
}
