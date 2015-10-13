<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151013113519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE editorLog DROP FOREIGN KEY FK_B8A647599D32F035');
        $this->addSql('ALTER TABLE editorLog DROP FOREIGN KEY FK_B8A64759232D562B');
        $this->addSql('DROP TABLE editorLog');
        $this->addSql('DROP TABLE editorLogAction');
        $this->addSql('DROP TABLE editorLogObject');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE editorLog (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, action_id INT DEFAULT NULL, user_id INT DEFAULT NULL, questionnaire_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B8A64759CE07E8FF (questionnaire_id), INDEX IDX_B8A647599D32F035 (action_id), INDEX IDX_B8A64759232D562B (object_id), INDEX IDX_B8A64759A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editorLogAction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editorLogObject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE editorLog ADD CONSTRAINT FK_B8A64759232D562B FOREIGN KEY (object_id) REFERENCES editorLogObject (id)');
        $this->addSql('ALTER TABLE editorLog ADD CONSTRAINT FK_B8A647599D32F035 FOREIGN KEY (action_id) REFERENCES editorLogAction (id)');
        $this->addSql('ALTER TABLE editorLog ADD CONSTRAINT FK_B8A64759A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE editorLog ADD CONSTRAINT FK_B8A64759CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
    }
}
