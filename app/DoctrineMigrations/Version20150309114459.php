<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150309114459 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE mediaClick ADD session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542EC613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_E55542EC613FECDF ON mediaClick (session_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE mediaClick DROP FOREIGN KEY FK_E55542EC613FECDF');
        $this->addSql('DROP INDEX IDX_E55542EC613FECDF ON mediaClick');
        $this->addSql('ALTER TABLE mediaClick DROP session_id');
    }
}
