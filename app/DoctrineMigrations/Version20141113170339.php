<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141113170339 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFDE8DA3B8');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF37B987D8');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF51804B42');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFC02DBF8E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E62A10F76');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF62A10F76');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFB0C1FC4A');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF453D776A');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF315B405');
        $this->addSql('CREATE TABLE questionnaire_user (questionnaire_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D90B99E0CE07E8FF (questionnaire_id), INDEX IDX_D90B99E0A76ED395 (user_id), PRIMARY KEY(questionnaire_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireReception (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireAuthorRight (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireLength (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireSourceOperation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireRegister (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire_user ADD CONSTRAINT FK_D90B99E0CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire_user ADD CONSTRAINT FK_D90B99E0A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questionnaireCognitiveOperation');
        $this->addSql('DROP TABLE questionnaireDuration');
        $this->addSql('DROP TABLE questionnaireFocus');
        $this->addSql('DROP TABLE questionnaireFunctionType');
        $this->addSql('DROP TABLE questionnaireInstruction');
        $this->addSql('DROP TABLE questionnaireReceptionType');
        $this->addSql('DROP TABLE questionnaireSourceType');
        $this->addSql('DROP TABLE questionnaireSupport');
        $this->addSql('DROP INDEX IDX_7A64DAF453D776A ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF62A10F76 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAFB0C1FC4A ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF37B987D8 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAFC02DBF8E ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAFDE8DA3B8 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF315B405 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF51804B42 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD register_id INT DEFAULT NULL, ADD reception_id INT DEFAULT NULL, ADD length_id INT DEFAULT NULL, ADD levelProof LONGTEXT DEFAULT NULL, ADD authorRightMore LONGTEXT DEFAULT NULL, ADD sourceMore LONGTEXT DEFAULT NULL, ADD authorRight_id INT DEFAULT NULL, ADD sourceOperation_id INT DEFAULT NULL, DROP support_id, DROP duration_id, DROP focus_id, DROP instruction_id, DROP sourceType_id, DROP receptionType_id, DROP functionType_id, DROP cognitiveOperation_id');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9C93745D FOREIGN KEY (authorRight_id) REFERENCES questionnaireAuthorRight (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3E5F0C25 FOREIGN KEY (sourceOperation_id) REFERENCES questionnaireSourceOperation (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF4976CB7E FOREIGN KEY (register_id) REFERENCES questionnaireRegister (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF7C14DF52 FOREIGN KEY (reception_id) REFERENCES questionnaireReception (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF61ED455A FOREIGN KEY (length_id) REFERENCES questionnaireLength (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF9C93745D ON questionnaire (authorRight_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF3E5F0C25 ON questionnaire (sourceOperation_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF4976CB7E ON questionnaire (register_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF7C14DF52 ON questionnaire (reception_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF61ED455A ON questionnaire (length_id)');
        $this->addSql('ALTER TABLE questionnaireFlow ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaireDomain ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaireSource ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_B6F7494E62A10F76 ON question');
        $this->addSql('ALTER TABLE question DROP instruction_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF7C14DF52');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9C93745D');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF61ED455A');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3E5F0C25');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF4976CB7E');
        $this->addSql('CREATE TABLE questionnaireCognitiveOperation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireDuration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireFocus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireFunctionType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireInstruction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireReceptionType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireSourceType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireSupport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE questionnaire_user');
        $this->addSql('DROP TABLE questionnaireReception');
        $this->addSql('DROP TABLE questionnaireAuthorRight');
        $this->addSql('DROP TABLE questionnaireLength');
        $this->addSql('DROP TABLE questionnaireSourceOperation');
        $this->addSql('DROP TABLE questionnaireRegister');
        $this->addSql('ALTER TABLE question ADD instruction_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E62A10F76 FOREIGN KEY (instruction_id) REFERENCES questionnaireInstruction (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E62A10F76 ON question (instruction_id)');
        $this->addSql('DROP INDEX IDX_7A64DAF9C93745D ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF3E5F0C25 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF4976CB7E ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF7C14DF52 ON questionnaire');
        $this->addSql('DROP INDEX IDX_7A64DAF61ED455A ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD support_id INT DEFAULT NULL, ADD duration_id INT DEFAULT NULL, ADD focus_id INT DEFAULT NULL, ADD instruction_id INT DEFAULT NULL, ADD sourceType_id INT DEFAULT NULL, ADD receptionType_id INT DEFAULT NULL, ADD functionType_id INT DEFAULT NULL, ADD cognitiveOperation_id INT DEFAULT NULL, DROP register_id, DROP reception_id, DROP length_id, DROP levelProof, DROP authorRightMore, DROP sourceMore, DROP authorRight_id, DROP sourceOperation_id');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFC02DBF8E FOREIGN KEY (functionType_id) REFERENCES questionnaireFunctionType (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF315B405 FOREIGN KEY (support_id) REFERENCES questionnaireSupport (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF37B987D8 FOREIGN KEY (duration_id) REFERENCES questionnaireDuration (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF453D776A FOREIGN KEY (sourceType_id) REFERENCES questionnaireSourceType (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF51804B42 FOREIGN KEY (focus_id) REFERENCES questionnaireFocus (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF62A10F76 FOREIGN KEY (instruction_id) REFERENCES questionnaireInstruction (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFB0C1FC4A FOREIGN KEY (receptionType_id) REFERENCES questionnaireReceptionType (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFDE8DA3B8 FOREIGN KEY (cognitiveOperation_id) REFERENCES questionnaireCognitiveOperation (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF453D776A ON questionnaire (sourceType_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF62A10F76 ON questionnaire (instruction_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFB0C1FC4A ON questionnaire (receptionType_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF37B987D8 ON questionnaire (duration_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFC02DBF8E ON questionnaire (functionType_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFDE8DA3B8 ON questionnaire (cognitiveOperation_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF315B405 ON questionnaire (support_id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF51804B42 ON questionnaire (focus_id)');
        $this->addSql('ALTER TABLE questionnaireDomain DROP description');
        $this->addSql('ALTER TABLE questionnaireFlow DROP description');
        $this->addSql('ALTER TABLE questionnaireSource DROP description');
    }
}
