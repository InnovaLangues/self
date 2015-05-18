<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150518133216 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams DROP FOREIGN KEY FK_9CD1CCF71E5D0459');
        $this->addSql('DROP INDEX UNIQ_9CD1CCF71E5D0459 ON phasedParams');
        $this->addSql('ALTER TABLE phasedParams DROP test_id');
        $this->addSql('ALTER TABLE test ADD phasedParams_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C4051DAF9 FOREIGN KEY (phasedParams_id) REFERENCES phasedParams (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D87F7E0C4051DAF9 ON test (phasedParams_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phasedParams ADD test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF71E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9CD1CCF71E5D0459 ON phasedParams (test_id)');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C4051DAF9');
        $this->addSql('DROP INDEX UNIQ_D87F7E0C4051DAF9 ON test');
        $this->addSql('ALTER TABLE test DROP phasedParams_id');
    }
}
