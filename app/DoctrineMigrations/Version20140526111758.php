<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140526111758 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit ADD media_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE mediaLimit ADD CONSTRAINT FK_203568ACEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_203568ACEA9FDD75 ON mediaLimit (media_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit DROP FOREIGN KEY FK_203568ACEA9FDD75");
        $this->addSql("DROP INDEX IDX_203568ACEA9FDD75 ON mediaLimit");
        $this->addSql("ALTER TABLE mediaLimit DROP media_id");
    }
}
