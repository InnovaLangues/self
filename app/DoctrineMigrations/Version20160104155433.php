<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160104155433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_result DROP FOREIGN KEY FK_7638DA2E613FECDF');
        $this->addSql('ALTER TABLE user_result DROP FOREIGN KEY FK_7638DA2EA76ED395');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2E613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2EA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_result DROP FOREIGN KEY FK_7638DA2EA76ED395');
        $this->addSql('ALTER TABLE user_result DROP FOREIGN KEY FK_7638DA2E613FECDF');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2EA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE user_result ADD CONSTRAINT FK_7638DA2E613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }
}
