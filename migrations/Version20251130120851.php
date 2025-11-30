<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130120851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_base (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, path_file VARCHAR(255) NOT NULL, feature VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, user_id INT NOT NULL, subject VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE context (id INT AUTO_INCREMENT NOT NULL, context_label VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE context_status (id INT AUTO_INCREMENT NOT NULL, context_id INT NOT NULL, status_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, key_word VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE Notification (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, priority_id INT NOT NULL, priority_label VARCHAR(50) NOT NULL, priority_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_instance (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, priority_id INT NOT NULL, project_template_id INT NOT NULL, comment_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_template (id INT AUTO_INCREMENT NOT NULL, project_template_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_template_sprint_template (id INT AUTO_INCREMENT NOT NULL, project_template_id INT NOT NULL, sprint_template_id INT NOT NULL, sprint_order INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_instance (id INT AUTO_INCREMENT NOT NULL, project_instance_id INT NOT NULL, priority_id INT NOT NULL, sprint_template_id INT NOT NULL, sprint_dependency_id INT NOT NULL, name VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, status_id INT NOT NULL, `order` INT NOT NULL, comment_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_task (id INT AUTO_INCREMENT NOT NULL, sprint_template_id INT NOT NULL, task_template_id INT NOT NULL, task_order INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sprint_template (id INT AUTO_INCREMENT NOT NULL, sprint_template_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, status_name VARCHAR(50) NOT NULL, status_context INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task_instance (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, task_template_id INT NOT NULL, sprint_instance_id INT NOT NULL, priority_id INT NOT NULL, status_id INT NOT NULL, type_task_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, due_date DATETIME NOT NULL, `order` INT NOT NULL, parent_task INT NOT NULL, dependency_id INT NOT NULL, comment_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task_template (id INT AUTO_INCREMENT NOT NULL, sprint_template_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, parent_task INT NOT NULL, type_task_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE technologie (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_task (id INT AUTO_INCREMENT NOT NULL, code_id INT NOT NULL, name VARCHAR(100) NOT NULL, path_file_script VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, automatique TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE code_base');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE context');
        $this->addSql('DROP TABLE context_status');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE Notification');
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
        $this->addSql('DROP TABLE technologie');
        $this->addSql('DROP TABLE type_task');
        $this->addSql('DROP TABLE user');
    }
}
