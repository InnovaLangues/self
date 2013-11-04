<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131104105108 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE questionnaireSkill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE questionnaire ADD skill_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF5585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF5585C142 ON questionnaire (skill_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF5585C142");
        $this->addSql("DROP TABLE questionnaireSkill");
        $this->addSql("DROP INDEX IDX_7A64DAF5585C142 ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire DROP skill_id");
    }
}
