<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150526093746 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF72B6F98CF');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF74F4A53F3');
        $this->addSql('DROP INDEX IDX_9CD1CCF72B6F98CF ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF74F4A53F3 ON phasedParams');
        $this->addSql('ALTER TABLE phasedParams DROP step4_threshold, DROP lowerPart4_id, DROP upperPart4_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams ADD step4_threshold INT NOT NULL, ADD lowerPart4_id INT DEFAULT NULL, ADD upperPart4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF72B6F98CF FOREIGN KEY (lowerPart4_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF74F4A53F3 FOREIGN KEY (upperPart4_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF72B6F98CF ON phasedParams (lowerPart4_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF74F4A53F3 ON phasedParams (upperPart4_id)');
    }
}
