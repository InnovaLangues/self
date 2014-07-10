<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140710165703 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE questionnaireComment (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_3B5C834ACE07E8FF (questionnaire_id), INDEX IDX_3B5C834AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE questionnaireComment ADD CONSTRAINT FK_3B5C834ACE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)");
        $this->addSql("ALTER TABLE questionnaireComment ADD CONSTRAINT FK_3B5C834AA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE questionnaireComment");
    }
}
