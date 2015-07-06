<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150706141713 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE scoreThresholds_ignoredLevels (skillscorethreshold_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_FB7F41F4F2008514 (skillscorethreshold_id), INDEX IDX_FB7F41F45FB14BA7 (level_id), PRIMARY KEY(skillscorethreshold_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scoreThresholds_ignoredLevels ADD CONSTRAINT FK_FB7F41F4F2008514 FOREIGN KEY (skillscorethreshold_id) REFERENCES skillScoreThreshold (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scoreThresholds_ignoredLevels ADD CONSTRAINT FK_FB7F41F45FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE scoreThresholds_ignoredLevels');
    }
}
