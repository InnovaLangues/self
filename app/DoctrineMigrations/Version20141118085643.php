<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141118085643 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE questionnaires_revisors (questionnaire_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1DB20B11CE07E8FF (questionnaire_id), INDEX IDX_1DB20B11A76ED395 (user_id), PRIMARY KEY(questionnaire_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_revisors ADD CONSTRAINT FK_1DB20B11CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_revisors ADD CONSTRAINT FK_1DB20B11A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questionnaire_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE questionnaire_user (questionnaire_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D90B99E0CE07E8FF (questionnaire_id), INDEX IDX_D90B99E0A76ED395 (user_id), PRIMARY KEY(questionnaire_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire_user ADD CONSTRAINT FK_D90B99E0A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaire_user ADD CONSTRAINT FK_D90B99E0CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE questionnaires_revisors');
    }
}
