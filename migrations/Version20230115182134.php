<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115182134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department_managers (department_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_90F7FA2CAE80F5DF (department_id), INDEX IDX_90F7FA2C8C03F15C (employee_id), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, PRIMARY KEY(department_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(150) NOT NULL, name VARCHAR(150) NOT NULL, surname VARCHAR(150) NOT NULL, identity_number BIGINT NOT NULL, insurance_number BIGINT NOT NULL, start_date DATETIME NOT NULL, dismissal_date DATETIME NOT NULL, department_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), FULLTEXT INDEX name_idx (name, surname), INDEX department_idx (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE leave_date (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, description LONGTEXT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, status_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, INDEX IDX_C4FC23C26BF700BD (status_id), INDEX IDX_C4FC23C28C03F15C (employee_id), INDEX range_idx (start_date, end_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE department_managers ADD CONSTRAINT FK_90F7FA2CAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE department_managers ADD CONSTRAINT FK_90F7FA2C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE leave_date ADD CONSTRAINT FK_C4FC23C26BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE leave_date ADD CONSTRAINT FK_C4FC23C28C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department_managers DROP FOREIGN KEY FK_90F7FA2CAE80F5DF');
        $this->addSql('ALTER TABLE department_managers DROP FOREIGN KEY FK_90F7FA2C8C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1AE80F5DF');
        $this->addSql('ALTER TABLE leave_date DROP FOREIGN KEY FK_C4FC23C26BF700BD');
        $this->addSql('ALTER TABLE leave_date DROP FOREIGN KEY FK_C4FC23C28C03F15C');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE department_managers');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE leave_date');
        $this->addSql('DROP TABLE status');
    }
}
