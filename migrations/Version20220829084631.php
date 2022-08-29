<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829084631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE attribute_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE security_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE attribute (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fact (id INT NOT NULL, attribute_id INT DEFAULT NULL, security_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6FA45B95B6E62EFA ON fact (attribute_id)');
        $this->addSql('CREATE INDEX IDX_6FA45B956DBE4214 ON fact (security_id)');
        $this->addSql('CREATE TABLE security (id INT NOT NULL, symbol VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B95B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fact ADD CONSTRAINT FK_6FA45B956DBE4214 FOREIGN KEY (security_id) REFERENCES security (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE attribute_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security_id_seq CASCADE');
        $this->addSql('ALTER TABLE fact DROP CONSTRAINT FK_6FA45B95B6E62EFA');
        $this->addSql('ALTER TABLE fact DROP CONSTRAINT FK_6FA45B956DBE4214');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE fact');
        $this->addSql('DROP TABLE security');
    }
}
