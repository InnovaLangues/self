<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141215095211 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE questionnaires_sourceType (questionnaire_id INT NOT NULL, sourcetype_id INT NOT NULL, INDEX IDX_C727588DCE07E8FF (questionnaire_id), INDEX IDX_C727588D8A804EF6 (sourcetype_id), PRIMARY KEY(questionnaire_id, sourcetype_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SourceType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaires_sourceType ADD CONSTRAINT FK_C727588DCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questionnaires_sourceType ADD CONSTRAINT FK_C727588D8A804EF6 FOREIGN KEY (sourcetype_id) REFERENCES SourceType (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE questionnaires_sourceType DROP FOREIGN KEY FK_C727588D8A804EF6');
        $this->addSql('DROP TABLE questionnaires_sourceType');
        $this->addSql('DROP TABLE SourceType');
    }
}
