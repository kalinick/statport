<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140206121441 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE event_result ADD club_id INT DEFAULT NULL, ADD ts VARCHAR(255) NOT NULL, ADD relay VARCHAR(1) NOT NULL, CHANGE age lsc_id INT NOT NULL");
        $this->addSql("ALTER TABLE event_result ADD CONSTRAINT FK_21F3B641C015B052 FOREIGN KEY (lsc_id) REFERENCES lsc (id)");
        $this->addSql("ALTER TABLE event_result ADD CONSTRAINT FK_21F3B64161190A32 FOREIGN KEY (club_id) REFERENCES club (id)");
        $this->addSql("CREATE INDEX IDX_21F3B641C015B052 ON event_result (lsc_id)");
        $this->addSql("CREATE INDEX IDX_21F3B64161190A32 ON event_result (club_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE event_result DROP FOREIGN KEY FK_21F3B641C015B052");
        $this->addSql("ALTER TABLE event_result DROP FOREIGN KEY FK_21F3B64161190A32");
        $this->addSql("DROP INDEX IDX_21F3B641C015B052 ON event_result");
        $this->addSql("DROP INDEX IDX_21F3B64161190A32 ON event_result");
        $this->addSql("ALTER TABLE event_result DROP club_id, DROP ts, DROP relay, CHANGE lsc_id age INT NOT NULL");
    }
}
