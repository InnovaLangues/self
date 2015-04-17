<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150414145601 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_task DROP FOREIGN KEY FK_CE4EA1B58DB60186');
        $this->addSql('DROP INDEX IDX_CE4EA1B58DB60186 ON right_user_task');
        $this->addSql('ALTER TABLE right_user_task CHANGE task_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B5158E0B66 FOREIGN KEY (target_id) REFERENCES questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_CE4EA1B5158E0B66 ON right_user_task (target_id)');
        $this->addSql('ALTER TABLE right_user_session DROP FOREIGN KEY FK_DE5ECC68613FECDF');
        $this->addSql('DROP INDEX IDX_DE5ECC68613FECDF ON right_user_session');
        $this->addSql('ALTER TABLE right_user_session CHANGE session_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68158E0B66 FOREIGN KEY (target_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_DE5ECC68158E0B66 ON right_user_session (target_id)');
        $this->addSql('ALTER TABLE rights ADD attribute VARCHAR(255) NOT NULL, ADD class VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE right_user_group DROP FOREIGN KEY FK_9D53E7FBFE54D947');
        $this->addSql('DROP INDEX IDX_9D53E7FBFE54D947 ON right_user_group');
        $this->addSql('ALTER TABLE right_user_group CHANGE group_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FB158E0B66 FOREIGN KEY (target_id) REFERENCES user_group (id)');
        $this->addSql('CREATE INDEX IDX_9D53E7FB158E0B66 ON right_user_group (target_id)');
        $this->addSql('ALTER TABLE right_user_someone DROP FOREIGN KEY FK_5F235AD5A516A100');
        $this->addSql('DROP INDEX IDX_5F235AD5A516A100 ON right_user_someone');
        $this->addSql('ALTER TABLE right_user_someone ADD canEditRights TINYINT(1) NOT NULL, CHANGE someone_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5158E0B66 FOREIGN KEY (target_id) REFERENCES self_user (id)');
        $this->addSql('CREATE INDEX IDX_5F235AD5158E0B66 ON right_user_someone (target_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_group DROP FOREIGN KEY FK_9D53E7FB158E0B66');
        $this->addSql('DROP INDEX IDX_9D53E7FB158E0B66 ON right_user_group');
        $this->addSql('ALTER TABLE right_user_group CHANGE target_id group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FBFE54D947 FOREIGN KEY (group_id) REFERENCES user_group (id)');
        $this->addSql('CREATE INDEX IDX_9D53E7FBFE54D947 ON right_user_group (group_id)');
        $this->addSql('ALTER TABLE right_user_session DROP FOREIGN KEY FK_DE5ECC68158E0B66');
        $this->addSql('DROP INDEX IDX_DE5ECC68158E0B66 ON right_user_session');
        $this->addSql('ALTER TABLE right_user_session CHANGE target_id session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_DE5ECC68613FECDF ON right_user_session (session_id)');
        $this->addSql('ALTER TABLE right_user_someone DROP FOREIGN KEY FK_5F235AD5158E0B66');
        $this->addSql('DROP INDEX IDX_5F235AD5158E0B66 ON right_user_someone');
        $this->addSql('ALTER TABLE right_user_someone DROP canEditRights, CHANGE target_id someone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5A516A100 FOREIGN KEY (someone_id) REFERENCES self_user (id)');
        $this->addSql('CREATE INDEX IDX_5F235AD5A516A100 ON right_user_someone (someone_id)');
        $this->addSql('ALTER TABLE right_user_task DROP FOREIGN KEY FK_CE4EA1B5158E0B66');
        $this->addSql('DROP INDEX IDX_CE4EA1B5158E0B66 ON right_user_task');
        $this->addSql('ALTER TABLE right_user_task CHANGE target_id task_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B58DB60186 FOREIGN KEY (task_id) REFERENCES questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_CE4EA1B58DB60186 ON right_user_task (task_id)');
        $this->addSql('ALTER TABLE rights DROP attribute, DROP class');
    }
}
