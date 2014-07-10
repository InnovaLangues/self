<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140710143403 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire ADD mediaFunctionalInstruction_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF2664265C FOREIGN KEY (mediaFunctionalInstruction_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF2664265C ON questionnaire (mediaFunctionalInstruction_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF2664265C");
        $this->addSql("DROP INDEX IDX_7A64DAF2664265C ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire DROP mediaFunctionalInstruction_id");
    }
}
