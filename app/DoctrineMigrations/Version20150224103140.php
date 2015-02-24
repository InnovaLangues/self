<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150224103140 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE componentType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE componentAlternative (id INT AUTO_INCREMENT NOT NULL, alternativeNumber INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, componentType_id INT DEFAULT NULL, componentAlternative_id INT DEFAULT NULL, INDEX IDX_49FEA1572FDB59F6 (componentType_id), INDEX IDX_49FEA157BD9C4B2E (componentAlternative_id), INDEX IDX_49FEA1571E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderQuestionnaireComponent (id INT AUTO_INCREMENT NOT NULL, component_id INT DEFAULT NULL, questionnaire_id INT DEFAULT NULL, displayOrder INT NOT NULL, INDEX IDX_906E94DBE2ABAFFF (component_id), INDEX IDX_906E94DBCE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA1572FDB59F6 FOREIGN KEY (componentType_id) REFERENCES componentType (id)');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA157BD9C4B2E FOREIGN KEY (componentAlternative_id) REFERENCES componentAlternative (id)');
        $this->addSql('ALTER TABLE component ADD CONSTRAINT FK_49FEA1571E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE orderQuestionnaireComponent ADD CONSTRAINT FK_906E94DBE2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('ALTER TABLE orderQuestionnaireComponent ADD CONSTRAINT FK_906E94DBCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE test ADD phased TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY FK_49FEA1572FDB59F6');
        $this->addSql('ALTER TABLE component DROP FOREIGN KEY FK_49FEA157BD9C4B2E');
        $this->addSql('ALTER TABLE orderQuestionnaireComponent DROP FOREIGN KEY FK_906E94DBE2ABAFFF');
        $this->addSql('DROP TABLE componentType');
        $this->addSql('DROP TABLE componentAlternative');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE orderQuestionnaireComponent');
        $this->addSql('ALTER TABLE test DROP phased');
    }
}
