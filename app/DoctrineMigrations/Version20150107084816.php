<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150107084816 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE proposition DROP title');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EEA9FDD75');
        $this->addSql('DROP INDEX IDX_B6F7494EEA9FDD75 ON question');
        $this->addSql('ALTER TABLE question DROP media_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE proposition ADD title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EEA9FDD75 ON question (media_id)');
    }
}
