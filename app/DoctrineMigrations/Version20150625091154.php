<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150625091154 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skillScoreThreshold ADD componentType_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skillScoreThreshold ADD CONSTRAINT FK_3CE007672FDB59F6 FOREIGN KEY (componentType_id) REFERENCES componentType (id)');
        $this->addSql('CREATE INDEX IDX_3CE007672FDB59F6 ON skillScoreThreshold (componentType_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skillScoreThreshold DROP FOREIGN KEY FK_3CE007672FDB59F6');
        $this->addSql('DROP INDEX IDX_3CE007672FDB59F6 ON skillScoreThreshold');
        $this->addSql('ALTER TABLE skillScoreThreshold DROP componentType_id');
    }
}
