<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140715095656 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE clueType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE clue (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, clueType_id INT DEFAULT NULL, INDEX IDX_268AADD1DCC8E71F (clueType_id), INDEX IDX_268AADD1EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE clue ADD CONSTRAINT FK_268AADD1DCC8E71F FOREIGN KEY (clueType_id) REFERENCES clueType (id)");
        $this->addSql("ALTER TABLE clue ADD CONSTRAINT FK_268AADD1EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C77639764A");
        $this->addSql("DROP INDEX IDX_BD67F4C77639764A ON subquestion");
        $this->addSql("ALTER TABLE subquestion CHANGE mediaclue_id clue_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C7FCCE328B FOREIGN KEY (clue_id) REFERENCES clue (id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C7FCCE328B ON subquestion (clue_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE clue DROP FOREIGN KEY FK_268AADD1DCC8E71F");
        $this->addSql("ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C7FCCE328B");
        $this->addSql("DROP TABLE clueType");
        $this->addSql("DROP TABLE clue");
        $this->addSql("DROP INDEX IDX_BD67F4C7FCCE328B ON subquestion");
        $this->addSql("ALTER TABLE subquestion CHANGE clue_id mediaClue_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C77639764A FOREIGN KEY (mediaClue_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_BD67F4C77639764A ON subquestion (mediaClue_id)");
    }
}
