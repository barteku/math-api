<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829090300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE fact_id_seq CASCADE');
        $this->addSql('ALTER TABLE fact DROP id');
        $this->addSql('ALTER TABLE fact ALTER attribute_id SET NOT NULL');
        $this->addSql('ALTER TABLE fact ALTER security_id SET NOT NULL');
        $this->addSql('ALTER TABLE fact ADD PRIMARY KEY (attribute_id, security_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE fact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX fact_pkey');
        $this->addSql('ALTER TABLE fact ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE fact ALTER attribute_id DROP NOT NULL');
        $this->addSql('ALTER TABLE fact ALTER security_id DROP NOT NULL');
        $this->addSql('ALTER TABLE fact ADD PRIMARY KEY (id)');
    }
}
