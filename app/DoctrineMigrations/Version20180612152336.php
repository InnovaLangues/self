<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180612152336 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire ADD createdBySelf TINYINT(1) DEFAULT NULL, ADD freeLicence TINYINT(1) DEFAULT NULL, ADD authorizationRequestedAt DATE DEFAULT NULL, ADD authorizationGrantedAt DATE DEFAULT NULL, ADD sourceContacts LONGTEXT DEFAULT NULL, ADD sourceUrl LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire DROP createdBySelf, DROP freeLicence, DROP authorizationRequestedAt, DROP authorizationGrantedAt, DROP sourceContacts, DROP sourceUrl');
    }
}
