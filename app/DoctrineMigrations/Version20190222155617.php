<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190222155617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mediaClick DROP FOREIGN KEY FK_E55542ECA76ED395');
        $this->addSql('ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mediaClick DROP FOREIGN KEY FK_E55542ECA76ED395');
        $this->addSql('ALTER TABLE mediaClick ADD CONSTRAINT FK_E55542ECA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
    }
}
