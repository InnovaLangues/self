<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140703155418 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE mediaPurpose (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE mediaClick DROP clickCount");
        $this->addSql("ALTER TABLE media ADD mediaPurpose_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C58630072 FOREIGN KEY (mediaPurpose_id) REFERENCES mediaPurpose (id)");
        $this->addSql("CREATE INDEX IDX_6A2CA10C58630072 ON media (mediaPurpose_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C58630072");
        $this->addSql("DROP TABLE mediaPurpose");
        $this->addSql("DROP INDEX IDX_6A2CA10C58630072 ON media");
        $this->addSql("ALTER TABLE media DROP mediaPurpose_id");
        $this->addSql("ALTER TABLE mediaClick ADD clickCount INT NOT NULL");
    }
}
