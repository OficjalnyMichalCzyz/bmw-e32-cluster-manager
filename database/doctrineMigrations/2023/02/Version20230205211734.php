<?php

declare(strict_types=1);

namespace E32CM\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205211734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create discord message queue';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
                CREATE TABLE `discord_messages_queue` (
                    `id` INT(16) NOT NULL AUTO_INCREMENT,
                    `body` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
                    `server` VARCHAR(64) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
                    `author` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
                    `sendDate` DATETIME NOT NULL DEFAULT current_timestamp(),
                    `channel` VARCHAR(64) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
                    `isPrivateMessage` TINYINT(1) UNSIGNED NOT NULL,
                    `hasAttachment` TINYINT(1) UNSIGNED NOT NULL,
                    PRIMARY KEY (`id`) USING BTREE
                )
                COLLATE='utf8mb4_general_ci'
                ENGINE=InnoDB
                ;
            "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE discord_messages_queue;");
    }
}
