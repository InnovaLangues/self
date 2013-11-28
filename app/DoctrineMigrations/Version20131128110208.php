<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131128110208 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user ADD studentType VARCHAR(255) DEFAULT NULL, ADD coSkill_id INT DEFAULT NULL, ADD ceSkill_id INT DEFAULT NULL, ADD eeSkill_id INT DEFAULT NULL, ADD lastSkill_id INT DEFAULT NULL, DROP globalDialang, DROP coDialang, DROP lansad");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF89351E50D FOREIGN KEY (coSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF867F6F93 FOREIGN KEY (ceSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8B611FD4 FOREIGN KEY (eeSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8BE377E21 FOREIGN KEY (lastSkill_id) REFERENCES questionnaireSkill (id)");
        $this->addSql("CREATE INDEX IDX_3303DEF89351E50D ON self_user (coSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF867F6F93 ON self_user (ceSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8B611FD4 ON self_user (eeSkill_id)");
        $this->addSql("CREATE INDEX IDX_3303DEF8BE377E21 ON self_user (lastSkill_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF89351E50D");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF867F6F93");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8B611FD4");
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8BE377E21");
        $this->addSql("DROP INDEX IDX_3303DEF89351E50D ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF867F6F93 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8B611FD4 ON self_user");
        $this->addSql("DROP INDEX IDX_3303DEF8BE377E21 ON self_user");
        $this->addSql("ALTER TABLE self_user ADD coDialang VARCHAR(255) DEFAULT NULL, ADD lansad VARCHAR(255) DEFAULT NULL, DROP coSkill_id, DROP ceSkill_id, DROP eeSkill_id, DROP lastSkill_id, CHANGE studenttype globalDialang VARCHAR(255) DEFAULT NULL");
    }
}
