<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170126102057 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF81559531');
        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF899656FE8');
        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8C4BE576');
        $this->addSql('DROP INDEX IDX_3303DEF899656FE8 ON self_user');
        $this->addSql('DROP INDEX IDX_3303DEF8C4BE576 ON self_user');
        $this->addSql('DROP INDEX IDX_3303DEF81559531 ON self_user');
        $this->addSql('ALTER TABLE self_user DROP coLevel_id, DROP ceLevel_id, DROP eeLevel_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user ADD coLevel_id INT DEFAULT NULL, ADD ceLevel_id INT DEFAULT NULL, ADD eeLevel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF81559531 FOREIGN KEY (eeLevel_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF899656FE8 FOREIGN KEY (coLevel_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8C4BE576 FOREIGN KEY (ceLevel_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('CREATE INDEX IDX_3303DEF899656FE8 ON self_user (coLevel_id)');
        $this->addSql('CREATE INDEX IDX_3303DEF8C4BE576 ON self_user (ceLevel_id)');
        $this->addSql('CREATE INDEX IDX_3303DEF81559531 ON self_user (eeLevel_id)');
    }
}
