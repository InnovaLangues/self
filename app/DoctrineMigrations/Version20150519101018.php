<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150519101018 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams ADD lowerPart1_id INT DEFAULT NULL, ADD upperPart1_id INT DEFAULT NULL, ADD lowerPart2_id INT DEFAULT NULL, ADD upperPart2_id INT DEFAULT NULL, ADD lowerPart3_id INT DEFAULT NULL, ADD upperPart3_id INT DEFAULT NULL, ADD lowerPart4_id INT DEFAULT NULL, ADD upperPart4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF71CB168FD FOREIGN KEY (lowerPart1_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF77894A3C1 FOREIGN KEY (upperPart1_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF7E04C713 FOREIGN KEY (lowerPart2_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF76A210C2F FOREIGN KEY (upperPart2_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF7B6B8A076 FOREIGN KEY (lowerPart3_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF7D29D6B4A FOREIGN KEY (upperPart3_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF72B6F98CF FOREIGN KEY (lowerPart4_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF74F4A53F3 FOREIGN KEY (upperPart4_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF71CB168FD ON phasedParams (lowerPart1_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF77894A3C1 ON phasedParams (upperPart1_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF7E04C713 ON phasedParams (lowerPart2_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF76A210C2F ON phasedParams (upperPart2_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF7B6B8A076 ON phasedParams (lowerPart3_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF7D29D6B4A ON phasedParams (upperPart3_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF72B6F98CF ON phasedParams (lowerPart4_id)');
        $this->addSql('CREATE INDEX IDX_9CD1CCF74F4A53F3 ON phasedParams (upperPart4_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF71CB168FD');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF77894A3C1');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF7E04C713');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF76A210C2F');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF7B6B8A076');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF7D29D6B4A');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF72B6F98CF');
        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF74F4A53F3');
        $this->addSql('DROP INDEX IDX_9CD1CCF71CB168FD ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF77894A3C1 ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF7E04C713 ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF76A210C2F ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF7B6B8A076 ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF7D29D6B4A ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF72B6F98CF ON phasedParams');
        $this->addSql('DROP INDEX IDX_9CD1CCF74F4A53F3 ON phasedParams');
        $this->addSql('ALTER TABLE phasedParams DROP lowerPart1_id, DROP upperPart1_id, DROP lowerPart2_id, DROP upperPart2_id, DROP lowerPart3_id, DROP upperPart3_id, DROP lowerPart4_id, DROP upperPart4_id');
    }
}
