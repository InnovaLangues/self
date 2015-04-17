<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150414135827 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE right_user_task (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, task_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canList TINYINT(1) NOT NULL, INDEX IDX_CE4EA1B5A76ED395 (user_id), INDEX IDX_CE4EA1B58DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user_session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, session_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canList TINYINT(1) NOT NULL, canExportIndividual TINYINT(1) NOT NULL, canExportCollective TINYINT(1) NOT NULL, INDEX IDX_DE5ECC68A76ED395 (user_id), INDEX IDX_DE5ECC68613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user_group (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, group_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canList TINYINT(1) NOT NULL, canImportCsv TINYINT(1) NOT NULL, INDEX IDX_9D53E7FBA76ED395 (user_id), INDEX IDX_9D53E7FBFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user_test (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, test_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canList TINYINT(1) NOT NULL, canDuplicate TINYINT(1) NOT NULL, canManageSession TINYINT(1) NOT NULL, canManageTask TINYINT(1) NOT NULL, INDEX IDX_444F049CA76ED395 (user_id), INDEX IDX_444F049C1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE right_user_someone (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, someone_id INT DEFAULT NULL, canCreate TINYINT(1) NOT NULL, canEdit TINYINT(1) NOT NULL, canDelete TINYINT(1) NOT NULL, canDeleteTrace TINYINT(1) NOT NULL, canEditPassword TINYINT(1) NOT NULL, INDEX IDX_5F235AD5A76ED395 (user_id), INDEX IDX_5F235AD5A516A100 (someone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B5A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B58DB60186 FOREIGN KEY (task_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FBA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FBFE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049CA76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049C1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5A76ED395 FOREIGN KEY (user_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5A516A100 FOREIGN KEY (someone_id) REFERENCES self_user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE right_user_task');
        $this->addSql('DROP TABLE right_user_session');
        $this->addSql('DROP TABLE right_user_group');
        $this->addSql('DROP TABLE right_user_test');
        $this->addSql('DROP TABLE right_user_someone');
    }
}
