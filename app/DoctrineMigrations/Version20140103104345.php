<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140103104345 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE answer ADD subquestion_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2551A7950A FOREIGN KEY (subquestion_id) REFERENCES subquestion (id)");
        $this->addSql("CREATE INDEX IDX_DADD4A2551A7950A ON answer (subquestion_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2551A7950A");
        $this->addSql("DROP INDEX IDX_DADD4A2551A7950A ON answer");
        $this->addSql("ALTER TABLE answer DROP subquestion_id");
    }
}
