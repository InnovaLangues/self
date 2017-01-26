<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170126095400 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE levelLansad DROP FOREIGN KEY FK_369C754282F1BAF4');
        $this->addSql('DROP INDEX IDX_369C754282F1BAF4 ON levelLansad');
        $this->addSql('ALTER TABLE levelLansad DROP language_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE levelLansad ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE levelLansad ADD CONSTRAINT FK_369C754282F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_369C754282F1BAF4 ON levelLansad (language_id)');
    }
}
