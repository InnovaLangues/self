<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140710103915 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit DROP FOREIGN KEY FK_203568AC1E5D0459");
        $this->addSql("DROP INDEX IDX_203568AC1E5D0459 ON mediaLimit");
        $this->addSql("ALTER TABLE mediaLimit DROP test_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit ADD test_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE mediaLimit ADD CONSTRAINT FK_203568AC1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)");
        $this->addSql("CREATE INDEX IDX_203568AC1E5D0459 ON mediaLimit (test_id)");
    }
}
