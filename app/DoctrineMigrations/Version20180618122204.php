<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180618122204 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire_flow DROP FOREIGN KEY FK_65899D97EB60D1B');
        $this->addSql('DROP TABLE questionnaireFlow');
        $this->addSql('DROP TABLE questionnaire_flow');
        $this->addSql('ALTER TABLE questionnaire ADD flow LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json_array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questionnaireFlow (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_flow (questionnaire_id INT NOT NULL, flow_id INT NOT NULL, INDEX IDX_65899D9CE07E8FF (questionnaire_id), INDEX IDX_65899D97EB60D1B (flow_id), PRIMARY KEY(questionnaire_id, flow_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire_flow ADD CONSTRAINT FK_65899D97EB60D1B FOREIGN KEY (flow_id) REFERENCES questionnaireFlow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire_flow ADD CONSTRAINT FK_65899D9CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire DROP flow');
    }
}
