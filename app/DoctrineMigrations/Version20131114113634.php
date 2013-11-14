<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131114113634 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE subquestion ADD mediaText_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C7E37A7189 FOREIGN KEY (mediaText_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C7E37A7189 ON subquestion (mediaText_id)");
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9898169F");
        $this->addSql("DROP INDEX IDX_7A64DAF9898169F ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire DROP mediaItem_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire ADD mediaItem_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9898169F FOREIGN KEY (mediaItem_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF9898169F ON questionnaire (mediaItem_id)");
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C7E37A7189");
        $this->addSql("DROP INDEX IDX_BD67F4C7E37A7189 ON subquestion");
        $this->addSql("ALTER TABLE subquestion DROP mediaText_id");
    }
}
