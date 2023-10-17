<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016090134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advertisements (id INT AUTO_INCREMENT NOT NULL, company INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, resume LONGTEXT DEFAULT NULL, posted_date DATE DEFAULT NULL, expiration_date DATE DEFAULT NULL, salary NUMERIC(10, 2) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, work_schedule VARCHAR(255) DEFAULT NULL, INDEX IDX_5C755F1E4FBF094F (company), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, industry VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_body (id INT AUTO_INCREMENT NOT NULL, person INT DEFAULT NULL, advertisements INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_449E2B3734DCD176 (person), INDEX IDX_449E2B375C755F1E (advertisements), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_applications (id INT AUTO_INCREMENT NOT NULL, ad INT DEFAULT NULL, email_body INT DEFAULT NULL, application_date DATE DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, email_sent TINYINT(1) NOT NULL, INDEX IDX_F8AAF3DF77E0ED58 (ad), INDEX IDX_F8AAF3DF449E2B37 (email_body), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE people (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(10) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advertisements ADD CONSTRAINT FK_5C755F1E4FBF094F FOREIGN KEY (company) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE email_body ADD CONSTRAINT FK_449E2B3734DCD176 FOREIGN KEY (person) REFERENCES people (id)');
        $this->addSql('ALTER TABLE email_body ADD CONSTRAINT FK_449E2B375C755F1E FOREIGN KEY (advertisements) REFERENCES advertisements (id)');
        $this->addSql('ALTER TABLE job_applications ADD CONSTRAINT FK_F8AAF3DF77E0ED58 FOREIGN KEY (ad) REFERENCES advertisements (id)');
        $this->addSql('ALTER TABLE job_applications ADD CONSTRAINT FK_F8AAF3DF449E2B37 FOREIGN KEY (email_body) REFERENCES email_body (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertisements DROP FOREIGN KEY FK_5C755F1E4FBF094F');
        $this->addSql('ALTER TABLE email_body DROP FOREIGN KEY FK_449E2B3734DCD176');
        $this->addSql('ALTER TABLE email_body DROP FOREIGN KEY FK_449E2B375C755F1E');
        $this->addSql('ALTER TABLE job_applications DROP FOREIGN KEY FK_F8AAF3DF77E0ED58');
        $this->addSql('ALTER TABLE job_applications DROP FOREIGN KEY FK_F8AAF3DF449E2B37');
        $this->addSql('DROP TABLE advertisements');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE email_body');
        $this->addSql('DROP TABLE job_applications');
        $this->addSql('DROP TABLE people');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
