<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210124034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE config_project_framework ADD name VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD framework_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE config_project_framework ADD CONSTRAINT FK_9F73577137AECF72 FOREIGN KEY (framework_id) REFERENCES framework (id)');
        $this->addSql('CREATE INDEX IDX_9F73577137AECF72 ON config_project_framework (framework_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE config_project_framework DROP FOREIGN KEY FK_9F73577137AECF72');
        $this->addSql('DROP INDEX IDX_9F73577137AECF72 ON config_project_framework');
        $this->addSql('ALTER TABLE config_project_framework DROP name, DROP created_at, DROP updated_at, DROP framework_id');
    }
}
