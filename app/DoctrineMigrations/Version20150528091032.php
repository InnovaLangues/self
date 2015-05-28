<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150528091032 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subquestion ADD level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subquestion ADD CONSTRAINT FK_BD67F4C75FB14BA7 FOREIGN KEY (level_id) REFERENCES questionnaireLevel (id)');
        $this->addSql('CREATE INDEX IDX_BD67F4C75FB14BA7 ON subquestion (level_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subquestion DROP FOREIGN KEY FK_BD67F4C75FB14BA7');
        $this->addSql('DROP INDEX IDX_BD67F4C75FB14BA7 ON subquestion');
        $this->addSql('ALTER TABLE subquestion DROP level_id');
    }
}
