<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607112505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD industry_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4712B19A734 FOREIGN KEY (industry_id) REFERENCES industry (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B4712B19A734 ON candidat (industry_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4712B19A734');
        $this->addSql('DROP INDEX IDX_6AB5B4712B19A734 ON candidat');
        $this->addSql('ALTER TABLE candidat DROP industry_id');
    }
}
