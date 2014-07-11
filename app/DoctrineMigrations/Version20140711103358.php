<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140711103358 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaireComment ADD description_id INT DEFAULT NULL, DROP description");
        $this->addSql("ALTER TABLE questionnaireComment ADD CONSTRAINT FK_3B5C834AD9F966B FOREIGN KEY (description_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_3B5C834AD9F966B ON questionnaireComment (description_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaireComment DROP FOREIGN KEY FK_3B5C834AD9F966B");
        $this->addSql("DROP INDEX IDX_3B5C834AD9F966B ON questionnaireComment");
        $this->addSql("ALTER TABLE questionnaireComment ADD description LONGTEXT DEFAULT NULL, DROP description_id");
    }
}
