<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210103827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_base (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, path_file VARCHAR(255) NOT NULL, feature VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, task_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9474526C8DB60186 (task_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE config_project_framework (id INT AUTO_INCREMENT NOT NULL, configuration JSON DEFAULT NULL, architecture JSON DEFAULT NULL, script JSON DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE context (id INT AUTO_INCREMENT NOT NULL, context_label VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE context_status (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, context_id INT NOT NULL, status_id INT NOT NULL, INDEX IDX_CCEC2E4B6B00C1CF (context_id), INDEX IDX_CCEC2E4B6BF700BD (status_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, key_word VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE framework (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, version VARCHAR(10) NOT NULL, configuration JSON DEFAULT NULL, icon VARCHAR(250) DEFAULT NULL, color VARCHAR(10) DEFAULT NULL, technology_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_9D766E194235D463 (technology_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, color VARCHAR(10) DEFAULT NULL, priority_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_instance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path_file_database VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(100) DEFAULT NULL, color VARCHAR(7) DEFAULT NULL, is_favory TINYINT DEFAULT 0 NOT NULL, position INT NOT NULL, path_project VARCHAR(255) DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, status_id INT NOT NULL, priority_id INT NOT NULL, project_template_id INT NOT NULL, comment_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, config_framework_id INT DEFAULT NULL, INDEX IDX_7F7E3A056BF700BD (status_id), INDEX IDX_7F7E3A05497B19F9 (priority_id), INDEX IDX_7F7E3A05CD15F843 (project_template_id), INDEX IDX_7F7E3A05F8697D13 (comment_id), INDEX IDX_7F7E3A05727ACA70 (parent_id), UNIQUE INDEX UNIQ_7F7E3A05E4AA6E05 (config_framework_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_template_sprint_template (id INT AUTO_INCREMENT NOT NULL, sprint_order INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, project_template_id INT NOT NULL, sprint_template_id INT NOT NULL, INDEX IDX_8EDBD67CCD15F843 (project_template_id), INDEX IDX_8EDBD67C51723B70 (sprint_template_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_instance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, icon VARCHAR(100) NOT NULL, color VARCHAR(7) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority_id INT NOT NULL, sprint_template_id INT NOT NULL, status_id INT NOT NULL, comment_id INT DEFAULT NULL, sprint_dependency_id INT DEFAULT NULL, project_instance_id INT NOT NULL, INDEX IDX_3237E7ED497B19F9 (priority_id), INDEX IDX_3237E7ED51723B70 (sprint_template_id), INDEX IDX_3237E7ED6BF700BD (status_id), INDEX IDX_3237E7EDF8697D13 (comment_id), INDEX IDX_3237E7EDE0618A78 (sprint_dependency_id), INDEX IDX_3237E7EDF29E85E6 (project_instance_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_task (id INT AUTO_INCREMENT NOT NULL, task_order INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sprint_template_id INT NOT NULL, task_template_id INT NOT NULL, INDEX IDX_69BC740951723B70 (sprint_template_id), INDEX IDX_69BC740943AFA28A (task_template_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, color VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, context_id INT NOT NULL, INDEX IDX_7B00651C6B00C1CF (context_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task_instance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, due_date DATETIME NOT NULL, position INT DEFAULT NULL, icon VARCHAR(100) NOT NULL, color VARCHAR(7) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, task_template_id INT NOT NULL, sprint_instance_id INT NOT NULL, priority_id INT NOT NULL, status_id INT NOT NULL, type_task_id INT NOT NULL, parent_task_id INT DEFAULT NULL, dependency_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, INDEX IDX_2F05B92A76ED395 (user_id), INDEX IDX_2F05B9243AFA28A (task_template_id), INDEX IDX_2F05B926EF946D5 (sprint_instance_id), INDEX IDX_2F05B92497B19F9 (priority_id), INDEX IDX_2F05B926BF700BD (status_id), INDEX IDX_2F05B92A5976E73 (type_task_id), INDEX IDX_2F05B92FFFE75C0 (parent_task_id), INDEX IDX_2F05B92C2F67723 (dependency_id), INDEX IDX_2F05B92F8697D13 (comment_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, parent_task INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sprint_template_id INT NOT NULL, type_task_id INT NOT NULL, INDEX IDX_D7A0F5CF51723B70 (sprint_template_id), INDEX IDX_D7A0F5CFA5976E73 (type_task_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_task (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, color VARCHAR(10) DEFAULT NULL, path_file_script VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, automatique TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, code_id INT NOT NULL, INDEX IDX_85711E2D27DAFE17 (code_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8DB60186 FOREIGN KEY (task_id) REFERENCES task_instance (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE context_status ADD CONSTRAINT FK_CCEC2E4B6B00C1CF FOREIGN KEY (context_id) REFERENCES context (id)');
        $this->addSql('ALTER TABLE context_status ADD CONSTRAINT FK_CCEC2E4B6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE framework ADD CONSTRAINT FK_9D766E194235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A056BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05CD15F843 FOREIGN KEY (project_template_id) REFERENCES project_template (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05727ACA70 FOREIGN KEY (parent_id) REFERENCES project_instance (id)');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05E4AA6E05 FOREIGN KEY (config_framework_id) REFERENCES config_project_framework (id)');
        $this->addSql('ALTER TABLE project_template_sprint_template ADD CONSTRAINT FK_8EDBD67CCD15F843 FOREIGN KEY (project_template_id) REFERENCES project_template (id)');
        $this->addSql('ALTER TABLE project_template_sprint_template ADD CONSTRAINT FK_8EDBD67C51723B70 FOREIGN KEY (sprint_template_id) REFERENCES sprint_template (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7ED497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7ED51723B70 FOREIGN KEY (sprint_template_id) REFERENCES sprint_template (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7ED6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7EDF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7EDE0618A78 FOREIGN KEY (sprint_dependency_id) REFERENCES sprint_instance (id)');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7EDF29E85E6 FOREIGN KEY (project_instance_id) REFERENCES project_instance (id)');
        $this->addSql('ALTER TABLE sprint_task ADD CONSTRAINT FK_69BC740951723B70 FOREIGN KEY (sprint_template_id) REFERENCES sprint_template (id)');
        $this->addSql('ALTER TABLE sprint_task ADD CONSTRAINT FK_69BC740943AFA28A FOREIGN KEY (task_template_id) REFERENCES task_template (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C6B00C1CF FOREIGN KEY (context_id) REFERENCES context (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B9243AFA28A FOREIGN KEY (task_template_id) REFERENCES task_template (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B926EF946D5 FOREIGN KEY (sprint_instance_id) REFERENCES sprint_instance (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B926BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92A5976E73 FOREIGN KEY (type_task_id) REFERENCES type_task (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92FFFE75C0 FOREIGN KEY (parent_task_id) REFERENCES task_instance (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92C2F67723 FOREIGN KEY (dependency_id) REFERENCES task_instance (id)');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B92F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE task_template ADD CONSTRAINT FK_D7A0F5CF51723B70 FOREIGN KEY (sprint_template_id) REFERENCES sprint_template (id)');
        $this->addSql('ALTER TABLE task_template ADD CONSTRAINT FK_D7A0F5CFA5976E73 FOREIGN KEY (type_task_id) REFERENCES type_task (id)');
        $this->addSql('ALTER TABLE type_task ADD CONSTRAINT FK_85711E2D27DAFE17 FOREIGN KEY (code_id) REFERENCES code_base (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8DB60186');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE context_status DROP FOREIGN KEY FK_CCEC2E4B6B00C1CF');
        $this->addSql('ALTER TABLE context_status DROP FOREIGN KEY FK_CCEC2E4B6BF700BD');
        $this->addSql('ALTER TABLE framework DROP FOREIGN KEY FK_9D766E194235D463');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A056BF700BD');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05497B19F9');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05CD15F843');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05F8697D13');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05727ACA70');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05E4AA6E05');
        $this->addSql('ALTER TABLE project_template_sprint_template DROP FOREIGN KEY FK_8EDBD67CCD15F843');
        $this->addSql('ALTER TABLE project_template_sprint_template DROP FOREIGN KEY FK_8EDBD67C51723B70');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7ED497B19F9');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7ED51723B70');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7ED6BF700BD');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7EDF8697D13');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7EDE0618A78');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7EDF29E85E6');
        $this->addSql('ALTER TABLE sprint_task DROP FOREIGN KEY FK_69BC740951723B70');
        $this->addSql('ALTER TABLE sprint_task DROP FOREIGN KEY FK_69BC740943AFA28A');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C6B00C1CF');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92A76ED395');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B9243AFA28A');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B926EF946D5');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92497B19F9');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B926BF700BD');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92A5976E73');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92FFFE75C0');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92C2F67723');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B92F8697D13');
        $this->addSql('ALTER TABLE task_template DROP FOREIGN KEY FK_D7A0F5CF51723B70');
        $this->addSql('ALTER TABLE task_template DROP FOREIGN KEY FK_D7A0F5CFA5976E73');
        $this->addSql('ALTER TABLE type_task DROP FOREIGN KEY FK_85711E2D27DAFE17');
        $this->addSql('DROP TABLE code_base');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE config_project_framework');
        $this->addSql('DROP TABLE context');
        $this->addSql('DROP TABLE context_status');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE framework');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE project_instance');
        $this->addSql('DROP TABLE project_template');
        $this->addSql('DROP TABLE project_template_sprint_template');
        $this->addSql('DROP TABLE sprint_instance');
        $this->addSql('DROP TABLE sprint_task');
        $this->addSql('DROP TABLE sprint_template');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE task_instance');
        $this->addSql('DROP TABLE task_template');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE type_task');
        $this->addSql('DROP TABLE user');
    }
}
