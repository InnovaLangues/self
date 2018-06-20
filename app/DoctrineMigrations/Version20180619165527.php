<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180619165527 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subquestion_focuses DROP FOREIGN KEY FK_E0566DAE51804B42');
        $this->addSql('DROP TABLE questionnaireFocus');
        $this->addSql('DROP TABLE subquestion_focuses');
        $this->addSql('ALTER TABLE subquestion ADD focuses LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questionnaireFocus (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subquestion_focuses (subquestion_id INT NOT NULL, focus_id INT NOT NULL, INDEX IDX_E0566DAE51A7950A (subquestion_id), INDEX IDX_E0566DAE51804B42 (focus_id), PRIMARY KEY(subquestion_id, focus_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subquestion_focuses ADD CONSTRAINT FK_E0566DAE51804B42 FOREIGN KEY (focus_id) REFERENCES questionnaireFocus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion_focuses ADD CONSTRAINT FK_E0566DAE51A7950A FOREIGN KEY (subquestion_id) REFERENCES subquestion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subquestion DROP focuses');
    }
}
