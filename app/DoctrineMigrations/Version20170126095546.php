<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170126095546 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8BEAECE74');
        $this->addSql('DROP INDEX IDX_3303DEF8BEAECE74 ON self_user');
        $this->addSql('ALTER TABLE self_user DROP levelLansad_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user ADD levelLansad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8BEAECE74 FOREIGN KEY (levelLansad_id) REFERENCES levelLansad (id)');
        $this->addSql('CREATE INDEX IDX_3303DEF8BEAECE74 ON self_user (levelLansad_id)');
    }
}
