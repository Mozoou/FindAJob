<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609180604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE companies CHANGE siret siret VARCHAR(255) NOT NULL, CHANGE siren siren VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE fax fax VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE formations DROP level');
        $this->addSql('ALTER TABLE school_degree DROP study_field');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE companies CHANGE siret siret VARCHAR(20) NOT NULL, CHANGE siren siren VARCHAR(11) NOT NULL, CHANGE phone phone VARCHAR(11) NOT NULL, CHANGE fax fax VARCHAR(11) DEFAULT NULL');
        $this->addSql('ALTER TABLE formations ADD level VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE school_degree ADD study_field VARCHAR(255) NOT NULL');
    }
}
