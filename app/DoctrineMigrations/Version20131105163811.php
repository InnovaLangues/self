<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131105163811 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE mediaType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, mediaType_id INT DEFAULT NULL, INDEX IDX_6A2CA10C4FBBC852 (mediaType_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4FBBC852 FOREIGN KEY (mediaType_id) REFERENCES mediaType (id)");
        $this->addSql("ALTER TABLE questionnaire ADD mediaInstruction_id INT DEFAULT NULL, ADD mediaContext_id INT DEFAULT NULL, ADD mediaItem_id INT DEFAULT NULL, DROP audioInstruction, DROP audioContext, DROP audioItem");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFE4F20921 FOREIGN KEY (mediaInstruction_id) REFERENCES media (id)");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF4CA1D08C FOREIGN KEY (mediaContext_id) REFERENCES media (id)");
        $this->addSql("ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF9898169F FOREIGN KEY (mediaItem_id) REFERENCES media (id)");
        $this->addSql("CREATE INDEX IDX_7A64DAFE4F20921 ON questionnaire (mediaInstruction_id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF4CA1D08C ON questionnaire (mediaContext_id)");
        $this->addSql("CREATE INDEX IDX_7A64DAF9898169F ON questionnaire (mediaItem_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4FBBC852");
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFE4F20921");
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF4CA1D08C");
        $this->addSql("ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF9898169F");
        $this->addSql("DROP TABLE mediaType");
        $this->addSql("DROP TABLE media");
        $this->addSql("DROP INDEX IDX_7A64DAFE4F20921 ON questionnaire");
        $this->addSql("DROP INDEX IDX_7A64DAF4CA1D08C ON questionnaire");
        $this->addSql("DROP INDEX IDX_7A64DAF9898169F ON questionnaire");
        $this->addSql("ALTER TABLE questionnaire ADD audioInstruction VARCHAR(255) NOT NULL, ADD audioContext VARCHAR(255) NOT NULL, ADD audioItem VARCHAR(255) NOT NULL, DROP mediaInstruction_id, DROP mediaContext_id, DROP mediaItem_id");
    }
}
