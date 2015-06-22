<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150622110919 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE skillScoreThreshold (id INT AUTO_INCREMENT NOT NULL, skill_id INT DEFAULT NULL, rightAnswers INT NOT NULL, description LONGTEXT DEFAULT NULL, phasedParam_id INT DEFAULT NULL, INDEX IDX_3CE007675585C142 (skill_id), INDEX IDX_3CE007674741BDE4 (phasedParam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skillScoreThreshold ADD CONSTRAINT FK_3CE007675585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id)');
        $this->addSql('ALTER TABLE skillScoreThreshold ADD CONSTRAINT FK_3CE007674741BDE4 FOREIGN KEY (phasedParam_id) REFERENCES phasedParams (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE skillScoreThreshold');
    }
}
