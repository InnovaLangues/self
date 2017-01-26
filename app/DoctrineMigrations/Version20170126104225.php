<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170126104225 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF76421FD8');
        $this->addSql('DROP INDEX IDX_7A64DAF76421FD8 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP languageLevel_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire ADD languageLevel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF76421FD8 FOREIGN KEY (languageLevel_id) REFERENCES questionnaireLanguageLevel (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF76421FD8 ON questionnaire (languageLevel_id)');
    }
}
