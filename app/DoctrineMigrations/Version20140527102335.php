<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140527102335 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE orderQuestionnaireTest (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, questionnaire_id INT DEFAULT NULL, displayOrder INT NOT NULL, INDEX IDX_964A1B6C1E5D0459 (test_id), INDEX IDX_964A1B6CCE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE orderQuestionnaireTest ADD CONSTRAINT FK_964A1B6C1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)");
        $this->addSql("ALTER TABLE orderQuestionnaireTest ADD CONSTRAINT FK_964A1B6CCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE orderQuestionnaireTest");
    }
}
