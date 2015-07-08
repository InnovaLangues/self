<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150708103803 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ignoredLevel (id INT AUTO_INCREMENT NOT NULL, skill_id INT DEFAULT NULL, componentType_id INT DEFAULT NULL, phasedParam_id INT DEFAULT NULL, INDEX IDX_C2A2C5125585C142 (skill_id), INDEX IDX_C2A2C5122FDB59F6 (componentType_id), INDEX IDX_C2A2C5124741BDE4 (phasedParam_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phasedParams_levels (ignoredlevel_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_E2E951F7EC03175 (ignoredlevel_id), INDEX IDX_E2E951F75FB14BA7 (level_id), PRIMARY KEY(ignoredlevel_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ignoredLevel ADD CONSTRAINT FK_C2A2C5125585C142 FOREIGN KEY (skill_id) REFERENCES questionnaireSkill (id)');
        $this->addSql('ALTER TABLE ignoredLevel ADD CONSTRAINT FK_C2A2C5122FDB59F6 FOREIGN KEY (componentType_id) REFERENCES componentType (id)');
        $this->addSql('ALTER TABLE ignoredLevel ADD CONSTRAINT FK_C2A2C5124741BDE4 FOREIGN KEY (phasedParam_id) REFERENCES phasedParams (id)');
        $this->addSql('ALTER TABLE phasedParams_levels ADD CONSTRAINT FK_E2E951F7EC03175 FOREIGN KEY (ignoredlevel_id) REFERENCES ignoredLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_levels ADD CONSTRAINT FK_E2E951F75FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE phasedParams_ignoredCE');
        $this->addSql('DROP TABLE phasedParams_ignoredCO');
        $this->addSql('DROP TABLE phasedParams_ignoredEEC');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams_levels DROP FOREIGN KEY FK_E2E951F7EC03175');
        $this->addSql('CREATE TABLE phasedParams_ignoredCE (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_F03AD214C2A0585A (phasedparams_id), INDEX IDX_F03AD2145FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phasedParams_ignoredCO (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_10EF3B0AC2A0585A (phasedparams_id), INDEX IDX_10EF3B0A5FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phasedParams_ignoredEEC (phasedparams_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_23706DBAC2A0585A (phasedparams_id), INDEX IDX_23706DBA5FB14BA7 (level_id), PRIMARY KEY(phasedparams_id, level_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phasedParams_ignoredCE ADD CONSTRAINT FK_F03AD2145FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCE ADD CONSTRAINT FK_F03AD214C2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCO ADD CONSTRAINT FK_10EF3B0A5FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredCO ADD CONSTRAINT FK_10EF3B0AC2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredEEC ADD CONSTRAINT FK_23706DBA5FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phasedParams_ignoredEEC ADD CONSTRAINT FK_23706DBAC2A0585A FOREIGN KEY (phasedparams_id) REFERENCES phasedParams (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ignoredLevel');
        $this->addSql('DROP TABLE phasedParams_levels');
    }
}
