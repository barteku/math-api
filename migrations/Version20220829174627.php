<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829174627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX name_idx ON attribute (name)');
        $this->addSql('ALTER TABLE fact ALTER value TYPE NUMERIC(3, 0) USING value::numeric(3,0)');
        $this->addSql('CREATE INDEX symbol_idx ON security (symbol)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX name_idx');
        $this->addSql('DROP INDEX symbol_idx');
        $this->addSql('ALTER TABLE fact ALTER value TYPE VARCHAR(255)');
    }
}
