<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221220101147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demand (id INT AUTO_INCREMENT NOT NULL, activity_funder_id INT NOT NULL, worker_inv_id INT DEFAULT NULL, activity_type VARCHAR(255) NOT NULL, activity_due_date DATE DEFAULT NULL, activity_goal VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, funding_recieved DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_428D79738BD0A23F (activity_funder_id), INDEX IDX_428D7973EECD6416 (worker_inv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_patient (demand_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_B5A039325D022E59 (demand_id), INDEX IDX_B5A039326B899279 (patient_id), PRIMARY KEY(demand_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_project (demand_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_80C93E375D022E59 (demand_id), INDEX IDX_80C93E37166D1F9C (project_id), PRIMARY KEY(demand_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_funding_patient (id INT AUTO_INCREMENT NOT NULL, demand_id INT NOT NULL, patient_id INT NOT NULL, fund DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C39CC1365D022E59 (demand_id), INDEX IDX_C39CC1366B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_funding_project (id INT AUTO_INCREMENT NOT NULL, demand_id INT NOT NULL, project_id INT NOT NULL, fund DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F6F5C6335D022E59 (demand_id), INDEX IDX_F6F5C633166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE funder (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, nbr_activities INT DEFAULT NULL, funder_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, health_status VARCHAR(255) NOT NULL, funding_needed DOUBLE PRECISION NOT NULL, patient_details VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, funding_needed DOUBLE PRECISION NOT NULL, project_details VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D79738BD0A23F FOREIGN KEY (activity_funder_id) REFERENCES funder (id)');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D7973EECD6416 FOREIGN KEY (worker_inv_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demand_patient ADD CONSTRAINT FK_B5A039325D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_patient ADD CONSTRAINT FK_B5A039326B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_project ADD CONSTRAINT FK_80C93E375D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_project ADD CONSTRAINT FK_80C93E37166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_funding_patient ADD CONSTRAINT FK_C39CC1365D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id)');
        $this->addSql('ALTER TABLE demand_funding_patient ADD CONSTRAINT FK_C39CC1366B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE demand_funding_project ADD CONSTRAINT FK_F6F5C6335D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id)');
        $this->addSql('ALTER TABLE demand_funding_project ADD CONSTRAINT FK_F6F5C633166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demand DROP FOREIGN KEY FK_428D79738BD0A23F');
        $this->addSql('ALTER TABLE demand DROP FOREIGN KEY FK_428D7973EECD6416');
        $this->addSql('ALTER TABLE demand_patient DROP FOREIGN KEY FK_B5A039325D022E59');
        $this->addSql('ALTER TABLE demand_patient DROP FOREIGN KEY FK_B5A039326B899279');
        $this->addSql('ALTER TABLE demand_project DROP FOREIGN KEY FK_80C93E375D022E59');
        $this->addSql('ALTER TABLE demand_project DROP FOREIGN KEY FK_80C93E37166D1F9C');
        $this->addSql('ALTER TABLE demand_funding_patient DROP FOREIGN KEY FK_C39CC1365D022E59');
        $this->addSql('ALTER TABLE demand_funding_patient DROP FOREIGN KEY FK_C39CC1366B899279');
        $this->addSql('ALTER TABLE demand_funding_project DROP FOREIGN KEY FK_F6F5C6335D022E59');
        $this->addSql('ALTER TABLE demand_funding_project DROP FOREIGN KEY FK_F6F5C633166D1F9C');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE demand_patient');
        $this->addSql('DROP TABLE demand_project');
        $this->addSql('DROP TABLE demand_funding_patient');
        $this->addSql('DROP TABLE demand_funding_project');
        $this->addSql('DROP TABLE funder');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
