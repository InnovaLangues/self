<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140624110014 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE subquestion ADD mediaClue_id INT DEFAULT NULL, ADD mediaSyllable_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C77639764A FOREIGN KEY (mediaClue_id) REFERENCES media (id)");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C7753D356C FOREIGN KEY (mediaSyllable_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C77639764A ON subquestion (mediaClue_id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C7753D356C ON subquestion (mediaSyllable_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C77639764A");
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C7753D356C");
        $this->addSql("DROP INDEX IDX_BD67F4C77639764A ON subquestion");
        $this->addSql("DROP INDEX IDX_BD67F4C7753D356C ON subquestion");
        $this->addSql("ALTER TABLE subquestion DROP mediaClue_id, DROP mediaSyllable_id");
    }
}
