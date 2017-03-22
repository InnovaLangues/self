<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170126095652 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user DROP FOREIGN KEY FK_3303DEF874DBA9A1');
        $this->addSql('DROP INDEX IDX_3303DEF874DBA9A1 ON self_user');
        $this->addSql('ALTER TABLE self_user DROP originStudent_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE self_user ADD originStudent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE self_user ADD CONSTRAINT FK_3303DEF874DBA9A1 FOREIGN KEY (originStudent_id) REFERENCES originStudent (id)');
        $this->addSql('CREATE INDEX IDX_3303DEF874DBA9A1 ON self_user (originStudent_id)');
    }
}
