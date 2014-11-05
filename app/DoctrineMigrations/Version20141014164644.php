<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141014164644 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE skill_typology (skill_id INT NOT NULL, typology_id INT NOT NULL, INDEX IDX_573EA50A5585C142 (skill_id), INDEX IDX_573EA50AC7D98C7A (typology_id), PRIMARY KEY(skill_id, typology_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_typology ADD CONSTRAINT FK_573EA50A5585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_typology ADD CONSTRAINT FK_573EA50AC7D98C7A FOREIGN KEY (typology_id) REFERENCES typology (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE skill_typology');
    }
}
