<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180611143323 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaires_channel DROP FOREIGN KEY FK_2C4F170072F5A1AA');
        $this->addSql('ALTER TABLE questionnaires_socialLocation DROP FOREIGN KEY FK_751FEFBDAB556334');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9C93745D');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF115F0EE5');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3C62C6D1');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7C14DF52');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF953C1C61');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3E5F0C25');
        $this->addSql('ALTER TABLE questionnaires_variety DROP FOREIGN KEY FK_B660085078C2BC47');
        $this->addSql('CREATE TABLE questionnaire_flow (questionnaire_id INT NOT NULL, flow_id INT NOT NULL, INDEX IDX_65899D9CE07E8FF (questionnaire_id), INDEX IDX_65899D97EB60D1B (flow_id), PRIMARY KEY(questionnaire_id, flow_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire_flow ADD CONSTRAINT FK_65899D9CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire_flow ADD CONSTRAINT FK_65899D97EB60D1B FOREIGN KEY (flow_id) REFERENCES questionnaireFlow (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE Channel');
        $this->addSql('DROP TABLE SocialLocation');
        $this->addSql('DROP TABLE questionnaireDomain');
        $this->addSql('DROP TABLE questionnaireProductionType');
        $this->addSql('DROP TABLE questionnaireReception');
        $this->addSql('DROP TABLE questionnaireSource');
        $this->addSql('DROP TABLE questionnaireSourceOperation');
        $this->addSql('DROP TABLE questionnaireVariety');
        $this->addSql('DROP TABLE questionnaires_channel');
        $this->addSql('DROP TABLE questionnaires_socialLocation');
        $this->addSql('DROP TABLE questionnaires_variety');
        $this->addSql('DROP INDEX IDX_7A64DAF953C1C61 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF115F0EE5 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF7EB60D1B ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF9C93745D ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF3E5F0C25 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF7C14DF52 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF3C62C6D1 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP domain_id, DROP reception_id, DROP flow_id, DROP source_id, DROP authorRightMore, DROP sourceMore, DROP sourceOperation_id, DROP productionType_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SocialLocation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireDomain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireProductionType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireReception (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireSource (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireSourceOperation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireVariety (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires_channel (questionnaire_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_2C4F1700CE07E8FF (questionnaire_id), INDEX IDX_2C4F170072F5A1AA (channel_id), PRIMARY KEY(questionnaire_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires_socialLocation (questionnaire_id INT NOT NULL, sociallocation_id INT NOT NULL, INDEX IDX_751FEFBDCE07E8FF (questionnaire_id), INDEX IDX_751FEFBDAB556334 (sociallocation_id), PRIMARY KEY(questionnaire_id, sociallocation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires_variety (questionnaire_id INT NOT NULL, variety_id INT NOT NULL, INDEX IDX_B6600850CE07E8FF (questionnaire_id), INDEX IDX_B660085078C2BC47 (variety_id), PRIMARY KEY(questionnaire_id, variety_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_channel ADD CONSTRAINT FK_2C4F170072F5A1AA FOREIGN KEY (channel_id) REFERENCES Channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_channel ADD CONSTRAINT FK_2C4F1700CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_socialLocation ADD CONSTRAINT FK_751FEFBDAB556334 FOREIGN KEY (sociallocation_id) REFERENCES SocialLocation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_socialLocation ADD CONSTRAINT FK_751FEFBDCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_variety ADD CONSTRAINT FK_B660085078C2BC47 FOREIGN KEY (variety_id) REFERENCES questionnaireVariety (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_variety ADD CONSTRAINT FK_B6600850CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questionnaire_flow');
        $this->addSql('ALTER TABLE questionnaire ADD domain_id INT DEFAULT NULL, ADD reception_id INT DEFAULT NULL, ADD flow_id INT DEFAULT NULL, ADD source_id INT DEFAULT NULL, ADD authorRightMore LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD sourceMore LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD sourceOperation_id INT DEFAULT NULL, ADD productionType_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF115F0EE5 FOREIGN KEY (domain_id) REFERENCES questionnaireDomain (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3C62C6D1 FOREIGN KEY (productionType_id) REFERENCES questionnaireProductionType (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3E5F0C25 FOREIGN KEY (sourceOperation_id) REFERENCES questionnaireSourceOperation (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7C14DF52 FOREIGN KEY (reception_id) REFERENCES questionnaireReception (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7EB60D1B FOREIGN KEY (flow_id) REFERENCES questionnaireFlow (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF953C1C61 FOREIGN KEY (source_id) REFERENCES questionnaireSource (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7A64DAF953C1C61 ON questionnaire (source_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF115F0EE5 ON questionnaire (domain_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF7EB60D1B ON questionnaire (flow_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF3E5F0C25 ON questionnaire (sourceOperation_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF7C14DF52 ON questionnaire (reception_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF3C62C6D1 ON questionnaire (productionType_id)');
    }
}
