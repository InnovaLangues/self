<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150601112323 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE generalScoreThreshold (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, rightAnswers INT NOT NULL, description LONGTEXT DEFAULT NULL, componentType_id INT DEFAULT NULL, phasedParam_id INT DEFAULT NULL, INDEX IDX_3F79B3722FDB59F6 (componentType_id), INDEX IDX_3F79B3725FB14BA7 (level_id), INDEX IDX_3F79B3724741BDE4 (phasedParam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE generalScoreThreshold ADD CONSTRAINT FK_3F79B3722FDB59F6 FOREIGN KEY (componentType_id) REFERENCES componentType (id)');
        $this->addSql('ALTER TABLE generalScoreThreshold ADD CONSTRAINT FK_3F79B3725FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('ALTER TABLE generalScoreThreshold ADD CONSTRAINT FK_3F79B3724741BDE4 FOREIGN KEY (phasedParam_id) REFERENCES phasedParams (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE generalScoreThreshold');
    }
}
