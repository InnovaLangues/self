<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150518161743 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_task DROP FOREIGN KEY FK_CE4EA1B5158E0B66');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B5158E0B66 FOREIGN KEY (target_id) REFERENCES questionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_session DROP FOREIGN KEY FK_DE5ECC68158E0B66');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68158E0B66 FOREIGN KEY (target_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_group DROP FOREIGN KEY FK_9D53E7FB158E0B66');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FB158E0B66 FOREIGN KEY (target_id) REFERENCES user_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_test DROP FOREIGN KEY FK_444F049C158E0B66');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049C158E0B66 FOREIGN KEY (target_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE right_user_someone DROP FOREIGN KEY FK_5F235AD5158E0B66');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5158E0B66 FOREIGN KEY (target_id) REFERENCES self_user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_group DROP FOREIGN KEY FK_9D53E7FB158E0B66');
        $this->addSql('ALTER TABLE right_user_group ADD CONSTRAINT FK_9D53E7FB158E0B66 FOREIGN KEY (target_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE right_user_session DROP FOREIGN KEY FK_DE5ECC68158E0B66');
        $this->addSql('ALTER TABLE right_user_session ADD CONSTRAINT FK_DE5ECC68158E0B66 FOREIGN KEY (target_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE right_user_someone DROP FOREIGN KEY FK_5F235AD5158E0B66');
        $this->addSql('ALTER TABLE right_user_someone ADD CONSTRAINT FK_5F235AD5158E0B66 FOREIGN KEY (target_id) REFERENCES self_user (id)');
        $this->addSql('ALTER TABLE right_user_task DROP FOREIGN KEY FK_CE4EA1B5158E0B66');
        $this->addSql('ALTER TABLE right_user_task ADD CONSTRAINT FK_CE4EA1B5158E0B66 FOREIGN KEY (target_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE right_user_test DROP FOREIGN KEY FK_444F049C158E0B66');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049C158E0B66 FOREIGN KEY (target_id) REFERENCES test (id)');
    }
}
