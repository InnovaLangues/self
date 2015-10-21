<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151021115437 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE year (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE self_user ADD year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF840C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_3303DEF840C1FEA7 ON self_user (year_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF840C1FEA7');
        $this->addSql('DROP TABLE year');
        $this->addSql('DROP INDEX IDX_3303DEF840C1FEA7 ON self_user');
        $this->addSql('ALTER TABLE self_user DROP year_id');
    }
}
