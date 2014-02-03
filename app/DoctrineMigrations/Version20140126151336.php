<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140126151336 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE distance (id INT AUTO_INCREMENT NOT NULL, length INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, meet_id INT NOT NULL, distance_id INT NOT NULL, style_id INT NOT NULL, course_id INT NOT NULL, lsc_id INT NOT NULL, club_id INT NOT NULL, INDEX IDX_3BAE0AA73BBBF66 (meet_id), INDEX IDX_3BAE0AA713192463 (distance_id), INDEX IDX_3BAE0AA7BACD6074 (style_id), INDEX IDX_3BAE0AA7591CC992 (course_id), INDEX IDX_3BAE0AA7C015B052 (lsc_id), INDEX IDX_3BAE0AA761190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE event_result (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, swimmer_id INT NOT NULL, seconds DOUBLE PRECISION NOT NULL, rank INT NOT NULL, age INT NOT NULL, INDEX IDX_21F3B64171F7E88B (event_id), INDEX IDX_21F3B641F27DFEC8 (swimmer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lsc (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE meet (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE process_state (id SMALLINT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(2) NOT NULL, title VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE swimmer (id INT NOT NULL, club_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) NOT NULL, gender VARCHAR(1) NOT NULL, birthday DATE DEFAULT NULL, clubEnteredDate DATE DEFAULT NULL, INDEX IDX_ED2BC5D261190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE swimming_style (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE time_standart (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE time_standart_result (id INT AUTO_INCREMENT NOT NULL, distance_id INT NOT NULL, style_id INT NOT NULL, course_id INT NOT NULL, time_standart_id INT NOT NULL, gender VARCHAR(1) NOT NULL, min_age INT NOT NULL, max_age INT NOT NULL, seconds DOUBLE PRECISION NOT NULL, INDEX IDX_471B080F13192463 (distance_id), INDEX IDX_471B080FBACD6074 (style_id), INDEX IDX_471B080F591CC992 (course_id), INDEX IDX_471B080FE1B1AF34 (time_standart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, state_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zip INT DEFAULT NULL, UNIQUE INDEX UNIQ_D95AB405A76ED395 (user_id), INDEX IDX_D95AB4055D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE unprocessed_result (id INT AUTO_INCREMENT NOT NULL, transaction_id INT NOT NULL, process_state_id SMALLINT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_9FAB42242FC0CB0F (transaction_id), INDEX IDX_9FAB4224F3296240 (process_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE unprocessed_result_transaction (id INT AUTO_INCREMENT NOT NULL, process_state_id SMALLINT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FD0D8B4FF3296240 (process_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE swimmers_order (id INT AUTO_INCREMENT NOT NULL, amount DOUBLE PRECISION NOT NULL, paymentInstruction_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_6142D1F4FD913E4D (paymentInstruction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE credits (id INT AUTO_INCREMENT NOT NULL, payment_instruction_id INT NOT NULL, payment_id INT DEFAULT NULL, attention_required TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, reversing_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, target_amount NUMERIC(10, 5) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4117D17E8789B572 (payment_instruction_id), INDEX IDX_4117D17E4C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE financial_transactions (id INT AUTO_INCREMENT NOT NULL, credit_id INT DEFAULT NULL, payment_id INT DEFAULT NULL, extended_data LONGTEXT DEFAULT NULL COMMENT '(DC2Type:extended_payment_data)', processed_amount NUMERIC(10, 5) NOT NULL, reason_code VARCHAR(100) DEFAULT NULL, reference_number VARCHAR(100) DEFAULT NULL, requested_amount NUMERIC(10, 5) NOT NULL, response_code VARCHAR(100) DEFAULT NULL, state SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, tracking_id VARCHAR(100) DEFAULT NULL, transaction_type SMALLINT NOT NULL, INDEX IDX_1353F2D9CE062FF9 (credit_id), INDEX IDX_1353F2D94C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, payment_instruction_id INT NOT NULL, approved_amount NUMERIC(10, 5) NOT NULL, approving_amount NUMERIC(10, 5) NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, deposited_amount NUMERIC(10, 5) NOT NULL, depositing_amount NUMERIC(10, 5) NOT NULL, expiration_date DATETIME DEFAULT NULL, reversing_approved_amount NUMERIC(10, 5) NOT NULL, reversing_credited_amount NUMERIC(10, 5) NOT NULL, reversing_deposited_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, target_amount NUMERIC(10, 5) NOT NULL, attention_required TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_65D29B328789B572 (payment_instruction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE payment_instructions (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(10, 5) NOT NULL, approved_amount NUMERIC(10, 5) NOT NULL, approving_amount NUMERIC(10, 5) NOT NULL, created_at DATETIME NOT NULL, credited_amount NUMERIC(10, 5) NOT NULL, crediting_amount NUMERIC(10, 5) NOT NULL, currency VARCHAR(3) NOT NULL, deposited_amount NUMERIC(10, 5) NOT NULL, depositing_amount NUMERIC(10, 5) NOT NULL, extended_data LONGTEXT NOT NULL COMMENT '(DC2Type:extended_payment_data)', payment_system_name VARCHAR(100) NOT NULL, reversing_approved_amount NUMERIC(10, 5) NOT NULL, reversing_credited_amount NUMERIC(10, 5) NOT NULL, reversing_deposited_amount NUMERIC(10, 5) NOT NULL, state SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73BBBF66 FOREIGN KEY (meet_id) REFERENCES meet (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA713192463 FOREIGN KEY (distance_id) REFERENCES distance (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7BACD6074 FOREIGN KEY (style_id) REFERENCES swimming_style (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7591CC992 FOREIGN KEY (course_id) REFERENCES course (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C015B052 FOREIGN KEY (lsc_id) REFERENCES lsc (id)");
        $this->addSql("ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA761190A32 FOREIGN KEY (club_id) REFERENCES club (id)");
        $this->addSql("ALTER TABLE event_result ADD CONSTRAINT FK_21F3B64171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)");
        $this->addSql("ALTER TABLE event_result ADD CONSTRAINT FK_21F3B641F27DFEC8 FOREIGN KEY (swimmer_id) REFERENCES swimmer (id)");
        $this->addSql("ALTER TABLE swimmer ADD CONSTRAINT FK_ED2BC5D261190A32 FOREIGN KEY (club_id) REFERENCES club (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080F13192463 FOREIGN KEY (distance_id) REFERENCES distance (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080FBACD6074 FOREIGN KEY (style_id) REFERENCES swimming_style (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080F591CC992 FOREIGN KEY (course_id) REFERENCES course (id)");
        $this->addSql("ALTER TABLE time_standart_result ADD CONSTRAINT FK_471B080FE1B1AF34 FOREIGN KEY (time_standart_id) REFERENCES time_standart (id)");
        $this->addSql("ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)");
        $this->addSql("ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4055D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)");
        $this->addSql("ALTER TABLE unprocessed_result ADD CONSTRAINT FK_9FAB42242FC0CB0F FOREIGN KEY (transaction_id) REFERENCES unprocessed_result_transaction (id)");
        $this->addSql("ALTER TABLE unprocessed_result ADD CONSTRAINT FK_9FAB4224F3296240 FOREIGN KEY (process_state_id) REFERENCES process_state (id)");
        $this->addSql("ALTER TABLE unprocessed_result_transaction ADD CONSTRAINT FK_FD0D8B4FF3296240 FOREIGN KEY (process_state_id) REFERENCES process_state (id)");
        $this->addSql("ALTER TABLE swimmers_order ADD CONSTRAINT FK_6142D1F4FD913E4D FOREIGN KEY (paymentInstruction_id) REFERENCES payment_instructions (id)");
        $this->addSql("ALTER TABLE credits ADD CONSTRAINT FK_4117D17E8789B572 FOREIGN KEY (payment_instruction_id) REFERENCES payment_instructions (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE credits ADD CONSTRAINT FK_4117D17E4C3A3BB FOREIGN KEY (payment_id) REFERENCES payments (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE financial_transactions ADD CONSTRAINT FK_1353F2D9CE062FF9 FOREIGN KEY (credit_id) REFERENCES credits (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE financial_transactions ADD CONSTRAINT FK_1353F2D94C3A3BB FOREIGN KEY (payment_id) REFERENCES payments (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE payments ADD CONSTRAINT FK_65D29B328789B572 FOREIGN KEY (payment_instruction_id) REFERENCES payment_instructions (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA761190A32");
        $this->addSql("ALTER TABLE swimmer DROP FOREIGN KEY FK_ED2BC5D261190A32");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7591CC992");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080F591CC992");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA713192463");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080F13192463");
        $this->addSql("ALTER TABLE event_result DROP FOREIGN KEY FK_21F3B64171F7E88B");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C015B052");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73BBBF66");
        $this->addSql("ALTER TABLE unprocessed_result DROP FOREIGN KEY FK_9FAB4224F3296240");
        $this->addSql("ALTER TABLE unprocessed_result_transaction DROP FOREIGN KEY FK_FD0D8B4FF3296240");
        $this->addSql("ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB4055D83CC1");
        $this->addSql("ALTER TABLE event_result DROP FOREIGN KEY FK_21F3B641F27DFEC8");
        $this->addSql("ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7BACD6074");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080FBACD6074");
        $this->addSql("ALTER TABLE time_standart_result DROP FOREIGN KEY FK_471B080FE1B1AF34");
        $this->addSql("ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405A76ED395");
        $this->addSql("ALTER TABLE unprocessed_result DROP FOREIGN KEY FK_9FAB42242FC0CB0F");
        $this->addSql("ALTER TABLE financial_transactions DROP FOREIGN KEY FK_1353F2D9CE062FF9");
        $this->addSql("ALTER TABLE credits DROP FOREIGN KEY FK_4117D17E4C3A3BB");
        $this->addSql("ALTER TABLE financial_transactions DROP FOREIGN KEY FK_1353F2D94C3A3BB");
        $this->addSql("ALTER TABLE swimmers_order DROP FOREIGN KEY FK_6142D1F4FD913E4D");
        $this->addSql("ALTER TABLE credits DROP FOREIGN KEY FK_4117D17E8789B572");
        $this->addSql("ALTER TABLE payments DROP FOREIGN KEY FK_65D29B328789B572");
        $this->addSql("DROP TABLE club");
        $this->addSql("DROP TABLE course");
        $this->addSql("DROP TABLE distance");
        $this->addSql("DROP TABLE event");
        $this->addSql("DROP TABLE event_result");
        $this->addSql("DROP TABLE lsc");
        $this->addSql("DROP TABLE meet");
        $this->addSql("DROP TABLE process_state");
        $this->addSql("DROP TABLE state");
        $this->addSql("DROP TABLE swimmer");
        $this->addSql("DROP TABLE swimming_style");
        $this->addSql("DROP TABLE time_standart");
        $this->addSql("DROP TABLE time_standart_result");
        $this->addSql("DROP TABLE user");
        $this->addSql("DROP TABLE user_profile");
        $this->addSql("DROP TABLE unprocessed_result");
        $this->addSql("DROP TABLE unprocessed_result_transaction");
        $this->addSql("DROP TABLE swimmers_order");
        $this->addSql("DROP TABLE credits");
        $this->addSql("DROP TABLE financial_transactions");
        $this->addSql("DROP TABLE payments");
        $this->addSql("DROP TABLE payment_instructions");
    }
}
