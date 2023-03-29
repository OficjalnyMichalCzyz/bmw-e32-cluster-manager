<?php

declare(strict_types=1);

namespace E32CM\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428231955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add default configuration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            INSERT INTO `application_configuration` (`config`, `application`) VALUES ('{\"channelWhitelist\":[],\"scrollSpeed\":\"FAST_SCROLLING\"}', 'DISCORD');
        "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM `cluster_manager`.`application_configuration`;");
    }
}
