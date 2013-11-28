<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131128113546 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8BE377E21");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF867F6F93");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF89351E50D");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8B611FD4");
        $this->addSql("DROP INDEX IDX_3303DEF89351E50D ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF867F6F93 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8B611FD4 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8BE377E21 ON self_user");
        $this->addSql("ALTER TABLE self_user ADD coLevel_id INT DEFAULT NULL, ADD ceLevel_id INT DEFAULT NULL, ADD eeLevel_id INT DEFAULT NULL, ADD lastLevel_id INT DEFAULT NULL, DROP coSkill_id, DROP ceSkill_id, DROP eeSkill_id, DROP lastSkill_id");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF899656FE8 FOREIGN KEY (coLevel_id) REFERENCES questionnaireLevel (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8C4BE576 FOREIGN KEY (ceLevel_id) REFERENCES questionnaireLevel (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF81559531 FOREIGN KEY (eeLevel_id) REFERENCES questionnaireLevel (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8B403F4C4 FOREIGN KEY (lastLevel_id) REFERENCES questionnaireLevel (id)");
        $this->addSql("CREATE INDEX IDX_3303DEF899656FE8 ON self_user (coLevel_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8C4BE576 ON self_user (ceLevel_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF81559531 ON self_user (eeLevel_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8B403F4C4 ON self_user (lastLevel_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF899656FE8");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8C4BE576");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF81559531");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8B403F4C4");
        $this->addSql("DROP INDEX IDX_3303DEF899656FE8 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8C4BE576 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF81559531 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8B403F4C4 ON self_user");
        $this->addSql("ALTER TABLE self_user ADD coSkill_id INT DEFAULT NULL, ADD ceSkill_id INT DEFAULT NULL, ADD eeSkill_id INT DEFAULT NULL, ADD lastSkill_id INT DEFAULT NULL, DROP coLevel_id, DROP ceLevel_id, DROP eeLevel_id, DROP lastLevel_id");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8BE377E21 FOREIGN KEY (lastSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF867F6F93 FOREIGN KEY (ceSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF89351E50D FOREIGN KEY (coSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8B611FD4 FOREIGN KEY (eeSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("CREATE INDEX IDX_3303DEF89351E50D ON self_user (coSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF867F6F93 ON self_user (ceSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8B611FD4 ON self_user (eeSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8BE377E21 ON self_user (lastSkill_id)");
    }
}
