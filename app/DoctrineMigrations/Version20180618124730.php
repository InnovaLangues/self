<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180618124730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF4976CB7E');
        $this->addSql('DROP TABLE questionnaireRegister');
        $this->addSql('DROP INDEX IDX_7A64DAF4976CB7E ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD register VARCHAR(255) DEFAULT NULL, DROP register_id, DROP comment');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questionnaireRegister (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire ADD register_id INT DEFAULT NULL, ADD comment LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, DROP register');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF4976CB7E FOREIGN KEY (register_id) REFERENCES questionnaireRegister (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7A64DAF4976CB7E ON questionnaire (register_id)');
    }
}
