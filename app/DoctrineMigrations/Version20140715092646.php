<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140715092646 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire ADD mediaFeedback_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF3DBB19BC FOREIGN KEY (mediaFeedback_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF3DBB19BC ON questionnaire (mediaFeedback_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF3DBB19BC");
        $this->addSql("DROP INDEX IDX_7A64DAF3DBB19BC ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire DROP mediaFeedback_id");
    }
}
