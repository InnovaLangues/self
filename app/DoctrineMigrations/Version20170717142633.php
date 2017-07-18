<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170717142633 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user ADD subcourse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF8CD7362AB FOREIGN KEY (subcourse_id) REFERENCES subcourse (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_3303DEF8CD7362AB ON self_user (subcourse_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF8CD7362AB');
        $this->addSql('DROP INDEX IDX_3303DEF8CD7362AB ON self_user');
        $this->addSql('ALTER TABLE self_user DROP subcourse_id');
    }
}
