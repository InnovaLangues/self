<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150622112844 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skillScoreThreshold ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skillScoreThreshold ADD CONSTRAINT FK_3CE007675FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('CREATE INDEX IDX_3CE007675FB14BA7 ON skillScoreThreshold (level_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skillScoreThreshold DROP FOREIGN KEY FK_3CE007675FB14BA7');
        $this->addSql('DROP INDEX IDX_3CE007675FB14BA7 ON skillScoreThreshold');
        $this->addSql('ALTER TABLE skillScoreThreshold DROP level_id');
    }
}
