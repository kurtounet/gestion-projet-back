<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205162659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE framework (id INT AUTO_INCREMENT NOT NULL, configuration JSON DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE project_instance ADD path_file_database VARCHAR(255) DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL, ADD discr VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE icon icon VARCHAR(100) DEFAULT NULL, CHANGE color color VARCHAR(7) DEFAULT NULL, CHANGE is_favory is_favory TINYINT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE framework');
        $this->addSql('ALTER TABLE project_instance DROP path_file_database, DROP path, DROP discr, CHANGE description description LONGTEXT NOT NULL, CHANGE icon icon VARCHAR(100) NOT NULL, CHANGE color color VARCHAR(7) NOT NULL, CHANGE is_favory is_favory TINYINT NOT NULL');
    }
}
