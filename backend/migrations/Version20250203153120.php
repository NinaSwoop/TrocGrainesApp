<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203153120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad (id SERIAL NOT NULL, owner_id INT NOT NULL, category_id INT NOT NULL, ad_status_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, location VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_77E0ED587E3C61F9 ON ad (owner_id)');
        $this->addSql('CREATE INDEX IDX_77E0ED5812469DE2 ON ad (category_id)');
        $this->addSql('CREATE INDEX IDX_77E0ED58EDCECA64 ON ad (ad_status_id)');
        $this->addSql('COMMENT ON COLUMN ad.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN ad.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ad_status (id SERIAL NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, recipient_id INT DEFAULT NULL, ad_id INT NOT NULL, transaction_status_id INT DEFAULT NULL, is_validate_by_recipient BOOLEAN NOT NULL, is_validate_by_sender BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1E92F8F78 ON transaction (recipient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D14F34D596 ON transaction (ad_id)');
        $this->addSql('CREATE INDEX IDX_723705D128D09BFE ON transaction (transaction_status_id)');
        $this->addSql('COMMENT ON COLUMN transaction.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transaction.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE transaction_status (id SERIAL NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED587E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED5812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58EDCECA64 FOREIGN KEY (ad_status_id) REFERENCES ad_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E92F8F78 FOREIGN KEY (recipient_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D128D09BFE FOREIGN KEY (transaction_status_id) REFERENCES transaction_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ad DROP CONSTRAINT FK_77E0ED587E3C61F9');
        $this->addSql('ALTER TABLE ad DROP CONSTRAINT FK_77E0ED5812469DE2');
        $this->addSql('ALTER TABLE ad DROP CONSTRAINT FK_77E0ED58EDCECA64');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1E92F8F78');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D14F34D596');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D128D09BFE');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE ad_status');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_status');
    }
}
