<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140717143028 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire ADD mediaBlankText_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF48CF71AD FOREIGN KEY (mediaBlankText_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF48CF71AD ON questionnaire (mediaBlankText_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF48CF71AD");
        $this->addSql("DROP INDEX IDX_7A64DAF48CF71AD ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire DROP mediaBlankText_id");
    }
}
