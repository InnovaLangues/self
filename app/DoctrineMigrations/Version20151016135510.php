<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151016135510 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_session DROP FOREIGN KEY FK_564481D8FE54D947');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE right_user_group DROP FOREIGN KEY FK_9D53E7FB158E0B66');
        $this->addSql('DROP TABLE group_session');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP TABLE right_user_group');
        $this->addSql('DROP TABLE user_group');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE group_session (group_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_564481D8FE54D947 (group_id), INDEX IDX_564481D8613FECDF (session_id), PRIMARY KEY(group_id, session_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_user (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4C98D39FE54D947 (group_id), INDEX IDX_A4C98D39A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user_group (id INT AUTO_INCREMENT NOT NULL, target_id INT DEFAULT NULL, user_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canList TINYINT(1) NOT NULL, canImportCsv TINYINT(1) NOT NULL, INDEX IDX_9D53E7FBA76ED395 (user_id), INDEX IDX_9D53E7FB158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_session ADD CONSTRAINT FK_564481D8613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_session ADD CONSTRAINT FK_564481D8FE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FB158E0B66 FOREIGN KEY (target_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FBA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id) ON DELETE CASCADE');
    }
}
