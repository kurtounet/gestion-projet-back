<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205165136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('DROP TABLE technologie');
        $this->addSql('ALTER TABLE framework ADD techno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE framework ADD CONSTRAINT FK_9D766E1951F3C1BC FOREIGN KEY (techno_id) REFERENCES technology (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D766E1951F3C1BC ON framework (techno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologie (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE technology');
        $this->addSql('ALTER TABLE framework DROP FOREIGN KEY FK_9D766E1951F3C1BC');
        $this->addSql('DROP INDEX UNIQ_9D766E1951F3C1BC ON framework');
        $this->addSql('ALTER TABLE framework DROP techno_id');
    }
}
