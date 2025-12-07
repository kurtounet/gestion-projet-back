<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205130950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_instance ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A05727ACA70 FOREIGN KEY (parent_id) REFERENCES project_instance (id)');
        $this->addSql('CREATE INDEX IDX_7F7E3A05727ACA70 ON project_instance (parent_id)');
        $this->addSql('ALTER TABLE sprint_instance CHANGE project_instance_id project_instance_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(100) NOT NULL, ADD last_name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A05727ACA70');
        $this->addSql('DROP INDEX IDX_7F7E3A05727ACA70 ON project_instance');
        $this->addSql('ALTER TABLE project_instance DROP parent_id');
        $this->addSql('ALTER TABLE sprint_instance CHANGE project_instance_id project_instance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name');
    }
}
