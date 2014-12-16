<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141216100707 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE questionnaires_variety (questionnaire_id INT NOT NULL, variety_id INT NOT NULL, INDEX IDX_B6600850CE07E8FF (questionnaire_id), INDEX IDX_B660085078C2BC47 (variety_id), PRIMARY KEY(questionnaire_id, variety_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireVariety (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_variety ADD CONSTRAINT FK_B6600850CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_variety ADD CONSTRAINT FK_B660085078C2BC47 FOREIGN KEY (variety_id) REFERENCES questionnaireVariety (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE questionnaires_variety DROP FOREIGN KEY FK_B660085078C2BC47');
        $this->addSql('DROP TABLE questionnaires_variety');
        $this->addSql('DROP TABLE questionnaireVariety');
    }
}
