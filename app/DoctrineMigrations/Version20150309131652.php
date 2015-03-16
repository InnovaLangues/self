<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150309131652 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE session ADD passwd VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mediaClick ADD component_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECE2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('CREATE INDEX IDX_E55542ECE2ABAFFF ON mediaClick (component_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE mediaClick DROP FOREIGN KEY FK_E55542ECE2ABAFFF');
        $this->addSql('DROP INDEX IDX_E55542ECE2ABAFFF ON mediaClick');
        $this->addSql('ALTER TABLE mediaClick DROP component_id');
        $this->addSql('ALTER TABLE session DROP passwd');
    }
}
