<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140205141216 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA761190A32");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C015B052");
        $this->addSql("DROP INDEX IDX_3BAE0AA7C015B052 ON event");
        $this->addSql("DROP INDEX IDX_3BAE0AA761190A32 ON event");
        $this->addSql("ALTER TABLE event ADD gender VARCHAR(1) NOT NULL, DROP club_id, DROP lsc_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE event ADD club_id INT NOT NULL, ADD lsc_id INT NOT NULL, DROP gender");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA761190A32 FOREIGN KEY (club_id) REFERENCES club (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C015B052 FOREIGN KEY (lsc_id) REFERENCES lsc (id)");
        $this->addSql("CREATE INDEX IDX_3BAE0AA7C015B052 ON event (lsc_id)");
        $this->addSql("CREATE INDEX IDX_3BAE0AA761190A32 ON event (club_id)");
    }
}
