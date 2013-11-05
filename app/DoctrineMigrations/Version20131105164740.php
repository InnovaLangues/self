<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131105164740 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE subquestion ADD media_id INT DEFAULT NULL, DROP audioUrl");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C7EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C7EA9FDD75 ON subquestion (media_id)");
        $this->addSql("ALTER TABLE question ADD media_id INT DEFAULT NULL, DROP audioUrl");
        $this->addSql("ALTER TABLE question ADD CONSTRAINT FK_B6F7494EEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_B6F7494EEA9FDD75 ON question (media_id)");
        $this->addSql("ALTER TABLE proposition ADD media_id INT DEFAULT NULL, DROP audioUrl");
        $this->addSql("ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC353EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_C7CDC353EA9FDD75 ON proposition (media_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC353EA9FDD75");
        $this->addSql("DROP INDEX IDX_C7CDC353EA9FDD75 ON proposition");
        $this->addSql("ALTER TABLE proposition ADD audioUrl VARCHAR(255) DEFAULT NULL, DROP media_id");
        $this->addSql("ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EEA9FDD75");
        $this->addSql("DROP INDEX IDX_B6F7494EEA9FDD75 ON question");
        $this->addSql("ALTER TABLE question ADD audioUrl VARCHAR(255) DEFAULT NULL, DROP media_id");
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C7EA9FDD75");
        $this->addSql("DROP INDEX IDX_BD67F4C7EA9FDD75 ON subquestion");
        $this->addSql("ALTER TABLE subquestion ADD audioUrl VARCHAR(255) DEFAULT NULL, DROP media_id");
    }
}
