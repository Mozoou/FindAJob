<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607112340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE industry (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat DROP studies_level, DROP formations, DROP pro_exp, DROP hard_skills, DROP soft_skills');
        $this->addSql('ALTER TABLE exp_pro ADD candidat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exp_pro ADD CONSTRAINT FK_5DDAC3468D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_5DDAC3468D0EB82 ON exp_pro (candidat_id)');
        $this->addSql('ALTER TABLE formations ADD candidat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_409021378D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('CREATE INDEX IDX_409021378D0EB82 ON formations (candidat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE industry');
        $this->addSql('ALTER TABLE candidat ADD studies_level VARCHAR(255) NOT NULL, ADD formations VARCHAR(255) DEFAULT NULL, ADD pro_exp INT NOT NULL, ADD hard_skills TINYTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD soft_skills LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE exp_pro DROP FOREIGN KEY FK_5DDAC3468D0EB82');
        $this->addSql('DROP INDEX IDX_5DDAC3468D0EB82 ON exp_pro');
        $this->addSql('ALTER TABLE exp_pro DROP candidat_id');
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_409021378D0EB82');
        $this->addSql('DROP INDEX IDX_409021378D0EB82 ON formations');
        $this->addSql('ALTER TABLE formations DROP candidat_id');
    }
}
