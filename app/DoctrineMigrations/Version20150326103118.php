<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150326103118 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3C62C6D1');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF115F0EE5');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3E5F0C25');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF4976CB7E');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF5585C142');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF61ED455A');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7B9E0E8B');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7EB60D1B');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF953C1C61');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9C93745D');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3C62C6D1 FOREIGN KEY (productionType_id) REFERENCES questionnaireProductionType (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF115F0EE5 FOREIGN KEY (domain_id) REFERENCES questionnaireDomain (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3E5F0C25 FOREIGN KEY (sourceOperation_id) REFERENCES questionnaireSourceOperation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF4976CB7E FOREIGN KEY (register_id) REFERENCES questionnaireRegister (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF5585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF61ED455A FOREIGN KEY (length_id) REFERENCES questionnaireLength (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7B9E0E8B FOREIGN KEY (textLength_id) REFERENCES questionnaireTextLength (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7EB60D1B FOREIGN KEY (flow_id) REFERENCES questionnaireFlow (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF953C1C61 FOREIGN KEY (source_id) REFERENCES questionnaireSource (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9C93745D FOREIGN KEY (authorRight_id) REFERENCES questionnaireAuthorRight (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF5585C142');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9C93745D');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF953C1C61');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3E5F0C25');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF115F0EE5');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3C62C6D1');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF4976CB7E');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF61ED455A');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7B9E0E8B');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7EB60D1B');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF5585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9C93745D FOREIGN KEY (authorRight_id) REFERENCES questionnaireAuthorRight (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF953C1C61 FOREIGN KEY (source_id) REFERENCES questionnaireSource (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3E5F0C25 FOREIGN KEY (sourceOperation_id) REFERENCES questionnaireSourceOperation (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF115F0EE5 FOREIGN KEY (domain_id) REFERENCES questionnaireDomain (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3C62C6D1 FOREIGN KEY (productionType_id) REFERENCES questionnaireProductionType (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF4976CB7E FOREIGN KEY (register_id) REFERENCES questionnaireRegister (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF61ED455A FOREIGN KEY (length_id) REFERENCES questionnaireLength (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7B9E0E8B FOREIGN KEY (textLength_id) REFERENCES questionnaireTextLength (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7EB60D1B FOREIGN KEY (flow_id) REFERENCES questionnaireFlow (id)');
    }
}
