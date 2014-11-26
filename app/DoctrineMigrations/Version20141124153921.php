<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141124153921 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE subquestion_focuses (subquestion_id INT NOT NULL, focus_id INT NOT NULL, INDEX IDX_E0566DAE51A7950A (subquestion_id), INDEX IDX_E0566DAE51804B42 (focus_id), PRIMARY KEY(subquestion_id, focus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subquestion_cognitiveOpsMain (subquestion_id INT NOT NULL, cognitiveoperation_id INT NOT NULL, INDEX IDX_7CDF40FE51A7950A (subquestion_id), INDEX IDX_7CDF40FEC6BC7840 (cognitiveoperation_id), PRIMARY KEY(subquestion_id, cognitiveoperation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subquestion_cognitiveOpsSecondary (subquestion_id INT NOT NULL, cognitiveoperation_id INT NOT NULL, INDEX IDX_CF8AC49A51A7950A (subquestion_id), INDEX IDX_CF8AC49AC6BC7840 (cognitiveoperation_id), PRIMARY KEY(subquestion_id, cognitiveoperation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireCognitiveOperation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaireFocus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subquestion_focuses ADD CONSTRAINT FK_E0566DAE51A7950A FOREIGN KEY (subquestion_id) REFERENCES subquestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_focuses ADD CONSTRAINT FK_E0566DAE51804B42 FOREIGN KEY (focus_id) REFERENCES questionnaireFocus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsMain ADD CONSTRAINT FK_7CDF40FE51A7950A FOREIGN KEY (subquestion_id) REFERENCES subquestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsMain ADD CONSTRAINT FK_7CDF40FEC6BC7840 FOREIGN KEY (cognitiveoperation_id) REFERENCES questionnaireCognitiveOperation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsSecondary ADD CONSTRAINT FK_CF8AC49A51A7950A FOREIGN KEY (subquestion_id) REFERENCES subquestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsSecondary ADD CONSTRAINT FK_CF8AC49AC6BC7840 FOREIGN KEY (cognitiveoperation_id) REFERENCES questionnaireCognitiveOperation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsMain DROP FOREIGN KEY FK_7CDF40FEC6BC7840');
        $this->addSql('ALTER TABLE subquestion_cognitiveOpsSecondary DROP FOREIGN KEY FK_CF8AC49AC6BC7840');
        $this->addSql('ALTER TABLE subquestion_focuses DROP FOREIGN KEY FK_E0566DAE51804B42');
        $this->addSql('DROP TABLE subquestion_focuses');
        $this->addSql('DROP TABLE subquestion_cognitiveOpsMain');
        $this->addSql('DROP TABLE subquestion_cognitiveOpsSecondary');
        $this->addSql('DROP TABLE questionnaireCognitiveOperation');
        $this->addSql('DROP TABLE questionnaireFocus');
    }
}
