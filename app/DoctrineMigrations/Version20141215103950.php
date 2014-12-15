<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141215103950 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE questionnaires_channel (questionnaire_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_2C4F1700CE07E8FF (questionnaire_id), INDEX IDX_2C4F170072F5A1AA (channel_id), PRIMARY KEY(questionnaire_id, channel_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_channel ADD CONSTRAINT FK_2C4F1700CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_channel ADD CONSTRAINT FK_2C4F170072F5A1AA FOREIGN KEY (channel_id) REFERENCES Channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE questionnaires_channel DROP FOREIGN KEY FK_2C4F170072F5A1AA');
        $this->addSql('DROP TABLE questionnaires_channel');
        $this->addSql('DROP TABLE Channel');
    }
}
