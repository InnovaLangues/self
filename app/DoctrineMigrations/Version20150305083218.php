<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150305083218 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D044D5D41E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D41E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE trace ADD component_id INT DEFAULT NULL, ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trace ADD CONSTRAINT FK_315BD5A1E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('ALTER TABLE trace ADD CONSTRAINT FK_315BD5A1613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_315BD5A1E2ABAFFF ON trace (component_id)');
        $this->addSql('CREATE INDEX IDX_315BD5A1613FECDF ON trace (session_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE trace DROP FOREIGN KEY FK_315BD5A1613FECDF');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP INDEX IDX_315BD5A1E2ABAFFF ON trace');
        $this->addSql('DROP INDEX IDX_315BD5A1613FECDF ON trace');
        $this->addSql('ALTER TABLE trace DROP component_id, DROP session_id');
    }
}
