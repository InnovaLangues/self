<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140526112726 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF839D5D484");
        $this->addSql("DROP INDEX IDX_3303DEF839D5D484 ON self_user");
        $this->addSql("ALTER TABLE self_user DROP mediaClicks_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user ADD mediaClicks_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF839D5D484 FOREIGN KEY (mediaClicks_id) REFERENCES mediaClick (id)");
        $this->addSql("CREATE INDEX IDX_3303DEF839D5D484 ON self_user (mediaClicks_id)");
    }
}
