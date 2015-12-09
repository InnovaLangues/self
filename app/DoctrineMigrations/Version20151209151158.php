<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151209151158 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_result (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, session_id INT DEFAULT NULL, general_score VARCHAR(255) DEFAULT NULL, eec_score VARCHAR(255) DEFAULT NULL, ce_score VARCHAR(255) DEFAULT NULL, co_score VARCHAR(255) DEFAULT NULL, INDEX IDX_7638DA2EA76ED395 (user_id), INDEX IDX_7638DA2E613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2EA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2E613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_result');
    }
}
