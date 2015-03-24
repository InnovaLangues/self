<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150324113837 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questionnaires_socialLocation (questionnaire_id INT NOT NULL, sociallocation_id INT NOT NULL, INDEX IDX_751FEFBDCE07E8FF (questionnaire_id), INDEX IDX_751FEFBDAB556334 (sociallocation_id), PRIMARY KEY(questionnaire_id, sociallocation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SocialLocation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_socialLocation ADD CONSTRAINT FK_751FEFBDCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_socialLocation ADD CONSTRAINT FK_751FEFBDAB556334 FOREIGN KEY (sociallocation_id) REFERENCES SocialLocation (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaires_socialLocation DROP FOREIGN KEY FK_751FEFBDAB556334');
        $this->addSql('DROP TABLE questionnaires_socialLocation');
        $this->addSql('DROP TABLE SocialLocation');
    }
}
