<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150413132749 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rights (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rightGroup_id INT DEFAULT NULL, INDEX IDX_160D10314B7E84A (rightGroup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user (right_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5A6BF9454976835 (right_id), INDEX IDX_5A6BF94A76ED395 (user_id), PRIMARY KEY(right_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rights ADD CONSTRAINT FK_160D10314B7E84A FOREIGN KEY (rightGroup_id) REFERENCES right_group (id)');
        $this->addSql('ALTER TABLE right_user ADD CONSTRAINT FK_5A6BF9454976835 FOREIGN KEY (right_id) REFERENCES rights (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user ADD CONSTRAINT FK_5A6BF94A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user DROP FOREIGN KEY FK_5A6BF9454976835');
        $this->addSql('ALTER TABLE rights DROP FOREIGN KEY FK_160D10314B7E84A');
        $this->addSql('DROP TABLE rights');
        $this->addSql('DROP TABLE right_user');
        $this->addSql('DROP TABLE right_group');
    }
}
