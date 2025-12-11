<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210232654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_instance ADD created_by_user_id INT DEFAULT NULL, ADD updated_by_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A057D182D95 FOREIGN KEY (created_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE project_instance ADD CONSTRAINT FK_7F7E3A052793CC5E FOREIGN KEY (updated_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7F7E3A057D182D95 ON project_instance (created_by_user_id)');
        $this->addSql('CREATE INDEX IDX_7F7E3A052793CC5E ON project_instance (updated_by_user_id)');
        $this->addSql('ALTER TABLE sprint_instance ADD created_by_user_id INT DEFAULT NULL, ADD updated_by_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7ED7D182D95 FOREIGN KEY (created_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sprint_instance ADD CONSTRAINT FK_3237E7ED2793CC5E FOREIGN KEY (updated_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_3237E7ED7D182D95 ON sprint_instance (created_by_user_id)');
        $this->addSql('CREATE INDEX IDX_3237E7ED2793CC5E ON sprint_instance (updated_by_user_id)');
        $this->addSql('ALTER TABLE task_instance ADD created_by_user_id INT DEFAULT NULL, ADD updated_by_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B927D182D95 FOREIGN KEY (created_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE task_instance ADD CONSTRAINT FK_2F05B922793CC5E FOREIGN KEY (updated_by_user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_2F05B927D182D95 ON task_instance (created_by_user_id)');
        $this->addSql('CREATE INDEX IDX_2F05B922793CC5E ON task_instance (updated_by_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A057D182D95');
        $this->addSql('ALTER TABLE project_instance DROP FOREIGN KEY FK_7F7E3A052793CC5E');
        $this->addSql('DROP INDEX IDX_7F7E3A057D182D95 ON project_instance');
        $this->addSql('DROP INDEX IDX_7F7E3A052793CC5E ON project_instance');
        $this->addSql('ALTER TABLE project_instance DROP created_by_user_id, DROP updated_by_user_id');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7ED7D182D95');
        $this->addSql('ALTER TABLE sprint_instance DROP FOREIGN KEY FK_3237E7ED2793CC5E');
        $this->addSql('DROP INDEX IDX_3237E7ED7D182D95 ON sprint_instance');
        $this->addSql('DROP INDEX IDX_3237E7ED2793CC5E ON sprint_instance');
        $this->addSql('ALTER TABLE sprint_instance DROP created_by_user_id, DROP updated_by_user_id');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B927D182D95');
        $this->addSql('ALTER TABLE task_instance DROP FOREIGN KEY FK_2F05B922793CC5E');
        $this->addSql('DROP INDEX IDX_2F05B927D182D95 ON task_instance');
        $this->addSql('DROP INDEX IDX_2F05B922793CC5E ON task_instance');
        $this->addSql('ALTER TABLE task_instance DROP created_by_user_id, DROP updated_by_user_id');
    }
}
