<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150518120156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phasedParams (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, step2_threshold INT NOT NULL, step3_threshold INT NOT NULL, step4_threshold INT NOT NULL, UNIQUE INDEX UNIQ_9CD1CCF71E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_pdo (session_id VARCHAR(255) NOT NULL, session_value LONGTEXT NOT NULL, session_time INT NOT NULL, PRIMARY KEY(session_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phasedParams ADD CONSTRAINT FK_9CD1CCF71E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE phasedParams');
        $this->addSql('DROP TABLE session_pdo');
    }
}
