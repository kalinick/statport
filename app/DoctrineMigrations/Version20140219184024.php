<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140219184024 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080F13192463");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080F591CC992");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080FBACD6074");
        $this->addSql("DROP INDEX IDX_471B080F13192463 ON time_standart_result");
        $this->addSql("DROP INDEX IDX_471B080FBACD6074 ON time_standart_result");
        $this->addSql("DROP INDEX IDX_471B080F591CC992 ON time_standart_result");
        $this->addSql("ALTER TABLE time_standart_result ADD event_template_id INT NOT NULL, DROP distance_id, DROP course_id, DROP style_id");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080FAE53DC38 FOREIGN KEY (event_template_id) REFERENCES event_template (id)");
        $this->addSql("CREATE INDEX IDX_471B080FAE53DC38 ON time_standart_result (event_template_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080FAE53DC38");
        $this->addSql("DROP INDEX IDX_471B080FAE53DC38 ON time_standart_result");
        $this->addSql("ALTER TABLE time_standart_result ADD course_id INT NOT NULL, ADD style_id INT NOT NULL, CHANGE event_template_id distance_id INT NOT NULL");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080F13192463 FOREIGN KEY (distance_id) REFERENCES distance (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080F591CC992 FOREIGN KEY (course_id) REFERENCES course (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080FBACD6074 FOREIGN KEY (style_id) REFERENCES swimming_style (id)");
        $this->addSql("CREATE INDEX IDX_471B080F13192463 ON time_standart_result (distance_id)");
        $this->addSql("CREATE INDEX IDX_471B080FBACD6074 ON time_standart_result (style_id)");
        $this->addSql("CREATE INDEX IDX_471B080F591CC992 ON time_standart_result (course_id)");
    }
}
