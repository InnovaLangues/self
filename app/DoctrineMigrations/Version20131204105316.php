<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131204105316 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE levelLansad (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_369C754282F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE originStudent (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE levelLansad ADD CONSTRAINT FK_369C754282F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)");
        $this->addSql("ALTER TABLE test ADD language_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)");
        $this->addSql("CREATE INDEX IDX_D87F7E0C82F1BAF4 ON test (language_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE levelLansad");
        $this->addSql("DROP TABLE originStudent");
        $this->addSql("ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C82F1BAF4");
        $this->addSql("DROP INDEX IDX_D87F7E0C82F1BAF4 ON test");
        $this->addSql("ALTER TABLE test DROP language_id");
    }
}
