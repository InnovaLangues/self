<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180613113533 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9C93745D');
        $this->addSql('DROP INDEX IDX_7A64DAF9C93745D ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD authorRight LONGTEXT NOT NULL, DROP authorRight_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire ADD authorRight_id INT DEFAULT NULL, DROP authorRight');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9C93745D FOREIGN KEY (authorRight_id) REFERENCES questionnaireAuthorRight (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7A64DAF9C93745D ON questionnaire (authorRight_id)');
    }
}
