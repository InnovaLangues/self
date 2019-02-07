<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190207105409 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_FF4925FB8A90ABA9 ON key_value');
        $this->addSql('ALTER TABLE key_value ADD k VARCHAR(255) NOT NULL, ADD v VARCHAR(255) NOT NULL, DROP `key`, DROP value');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF4925FB862575D ON key_value (k)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_FF4925FB862575D ON key_value');
        $this->addSql('ALTER TABLE key_value ADD `key` VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD value VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP k, DROP v');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF4925FB8A90ABA9 ON key_value (`key`)');
    }
}
