<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607095851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exp_pro (id INT AUTO_INCREMENT NOT NULL, starting_date DATE NOT NULL, ending_date DATE DEFAULT NULL, currently TINYINT(1) NOT NULL, job_description VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, job_field VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations (id INT AUTO_INCREMENT NOT NULL, school_degree_id INT NOT NULL, starting_date DATE NOT NULL, ending_date DATE DEFAULT NULL, currently TINYINT(1) NOT NULL, level VARCHAR(255) NOT NULL, INDEX IDX_40902137C21394EB (school_degree_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_degree (id INT AUTO_INCREMENT NOT NULL, level VARCHAR(255) NOT NULL, study_field VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_40902137C21394EB FOREIGN KEY (school_degree_id) REFERENCES school_degree (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_40902137C21394EB');
        $this->addSql('DROP TABLE exp_pro');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE school_degree');
    }
}
