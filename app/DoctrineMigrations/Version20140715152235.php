<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140715152235 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE editorLog ADD user_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE editorLog ADD CONSTRAINT FK_B8A64759A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)");
        $this->addSql("CREATE INDEX IDX_B8A64759A76ED395 ON editorLog (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE editorLog DROP FOREIGN KEY FK_B8A64759A76ED395");
        $this->addSql("DROP INDEX IDX_B8A64759A76ED395 ON editorLog");
        $this->addSql("ALTER TABLE editorLog DROP user_id");
    }
}
