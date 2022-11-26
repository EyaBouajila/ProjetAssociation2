<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118102351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demand (id INT AUTO_INCREMENT NOT NULL, activity_funder_id INT NOT NULL, demand_date DATE NOT NULL, activity_type VARCHAR(255) NOT NULL, activity_due_date DATE NOT NULL, activity_goal VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_428D79738BD0A23F (activity_funder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_patient (demand_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_B5A039325D022E59 (demand_id), INDEX IDX_B5A039326B899279 (patient_id), PRIMARY KEY(demand_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_project (demand_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_80C93E375D022E59 (demand_id), INDEX IDX_80C93E37166D1F9C (project_id), PRIMARY KEY(demand_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_worker (demand_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_EF472ACB5D022E59 (demand_id), INDEX IDX_EF472ACB6B20BA36 (worker_id), PRIMARY KEY(demand_id, worker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE funder (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, nbr_activities INT DEFAULT NULL, funder_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, health_status VARCHAR(255) NOT NULL, funding_needed DOUBLE PRECISION NOT NULL, patient_details VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, funding_needed DOUBLE PRECISION NOT NULL, project_details VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D79738BD0A23F FOREIGN KEY (activity_funder_id) REFERENCES funder (id)');
        $this->addSql('ALTER TABLE demand_patient ADD CONSTRAINT FK_B5A039325D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_patient ADD CONSTRAINT FK_B5A039326B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_project ADD CONSTRAINT FK_80C93E375D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_project ADD CONSTRAINT FK_80C93E37166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_worker ADD CONSTRAINT FK_EF472ACB5D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_worker ADD CONSTRAINT FK_EF472ACB6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demand DROP FOREIGN KEY FK_428D79738BD0A23F');
        $this->addSql('ALTER TABLE demand_patient DROP FOREIGN KEY FK_B5A039325D022E59');
        $this->addSql('ALTER TABLE demand_patient DROP FOREIGN KEY FK_B5A039326B899279');
        $this->addSql('ALTER TABLE demand_project DROP FOREIGN KEY FK_80C93E375D022E59');
        $this->addSql('ALTER TABLE demand_project DROP FOREIGN KEY FK_80C93E37166D1F9C');
        $this->addSql('ALTER TABLE demand_worker DROP FOREIGN KEY FK_EF472ACB5D022E59');
        $this->addSql('ALTER TABLE demand_worker DROP FOREIGN KEY FK_EF472ACB6B20BA36');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE demand_patient');
        $this->addSql('DROP TABLE demand_project');
        $this->addSql('DROP TABLE demand_worker');
        $this->addSql('DROP TABLE funder');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE worker');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
