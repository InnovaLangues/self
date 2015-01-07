<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150107143443 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE test ADD testOrigin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C6FF0BF59 FOREIGN KEY (testOrigin_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C6FF0BF59 ON test (testOrigin_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C6FF0BF59');
        $this->addSql('DROP INDEX IDX_D87F7E0C6FF0BF59 ON test');
        $this->addSql('ALTER TABLE test DROP testOrigin_id');
    }
}
