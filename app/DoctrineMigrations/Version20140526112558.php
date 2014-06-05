<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140526112558 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE mediaClick (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, test_id INT DEFAULT NULL, questionnaire_id INT DEFAULT NULL, user_id INT DEFAULT NULL, clickCount INT NOT NULL, INDEX IDX_E55542ECEA9FDD75 (media_id), INDEX IDX_E55542EC1E5D0459 (test_id), INDEX IDX_E55542ECCE07E8FF (questionnaire_id), INDEX IDX_E55542ECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)");
        $this->addSql("ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542EC1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)");
        $this->addSql("ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECCE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)");
        $this->addSql("ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)");
        $this->addSql("ALTER TABLE self_user ADD mediaClicks_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF839D5D484 FOREIGN KEY (mediaClicks_id) REFERENCES mediaClick (id)");
        $this->addSql("CREATE INDEX IDX_3303DEF839D5D484 ON self_user (mediaClicks_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF839D5D484");
        $this->addSql("DROP TABLE mediaClick");
        $this->addSql("DROP INDEX IDX_3303DEF839D5D484 ON self_user");
        $this->addSql("ALTER TABLE self_user DROP mediaClicks_id");
    }
}
