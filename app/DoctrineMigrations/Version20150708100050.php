<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150708100050 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phasedParams_ignoredCO (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_10EF3B0AC2A0585A (phasedparams_id), INDEX IDX_10EF3B0A5FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phasedParams_ignoredCE (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_F03AD214C2A0585A (phasedparams_id), INDEX IDX_F03AD2145FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phasedParams_ignoredEEC (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_23706DBAC2A0585A (phasedparams_id), INDEX IDX_23706DBA5FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phasedParams_ignoredCO ADD CONSTRAINT FK_10EF3B0AC2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCO ADD CONSTRAINT FK_10EF3B0A5FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCE ADD CONSTRAINT FK_F03AD214C2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCE ADD CONSTRAINT FK_F03AD2145FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredEEC ADD CONSTRAINT FK_23706DBAC2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredEEC ADD CONSTRAINT FK_23706DBA5FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE scoreThresholds_ignoredLevels');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE scoreThresholds_ignoredLevels (skillscorethreshold_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_FB7F41F4F2008514 (skillscorethreshold_id), INDEX IDX_FB7F41F45FB14BA7 (level_id), PRIMARY KEY(skillscorethreshold_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scoreThresholds_ignoredLevels ADD CONSTRAINT FK_FB7F41F45FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scoreThresholds_ignoredLevels ADD CONSTRAINT FK_FB7F41F4F2008514 FOREIGN KEY (skillscorethreshold_id) REFERENCES skillScoreThreshold (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE phasedParams_ignoredCO');
        $this->addSql('DROP TABLE phasedParams_ignoredCE');
        $this->addSql('DROP TABLE phasedParams_ignoredEEC');
    }
}
