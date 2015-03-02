<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150302105209 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C6FF0BF59');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C6FF0BF59 FOREIGN KEY (testOrigin_id) REFERENCES test (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C6FF0BF59');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C6FF0BF59 FOREIGN KEY (testOrigin_id) REFERENCES test (id)');
    }
}
