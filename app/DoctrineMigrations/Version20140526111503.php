<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140526111503 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit ADD questionnaire_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE mediaLimit ADD CONSTRAINT FK_203568ACCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)");
        $this->addSql("CREATE INDEX IDX_203568ACCE07E8FF ON mediaLimit (questionnaire_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE mediaLimit DROP FOREIGN KEY FK_203568ACCE07E8FF");
        $this->addSql("DROP INDEX IDX_203568ACCE07E8FF ON mediaLimit");
        $this->addSql("ALTER TABLE mediaLimit DROP questionnaire_id");
    }
}
