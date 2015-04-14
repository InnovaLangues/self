<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150414151524 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_test DROP FOREIGN KEY FK_444F049C1E5D0459');
        $this->addSql('DROP INDEX IDX_444F049C1E5D0459 ON right_user_test');
        $this->addSql('ALTER TABLE right_user_test CHANGE test_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049C158E0B66 FOREIGN KEY (target_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_444F049C158E0B66 ON right_user_test (target_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE right_user_test DROP FOREIGN KEY FK_444F049C158E0B66');
        $this->addSql('DROP INDEX IDX_444F049C158E0B66 ON right_user_test');
        $this->addSql('ALTER TABLE right_user_test CHANGE target_id test_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE right_user_test ADD CONSTRAINT FK_444F049C1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_444F049C1E5D0459 ON right_user_test (test_id)');
    }
}
