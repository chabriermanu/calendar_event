<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260111184534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_2473f2137e3c61f9');
        $this->addSql('ALTER TABLE famille ADD family_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE famille ADD CONSTRAINT FK_2473F2133CEE3234 FOREIGN KEY (family_group_id) REFERENCES family_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2473F2137E3C61F9 ON famille (owner_id)');
        $this->addSql('CREATE INDEX IDX_2473F2133CEE3234 ON famille (family_group_id)');
        $this->addSql('ALTER TABLE photo ALTER uploaded_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING uploaded_at::timestamp(0) without time zone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE photo ALTER uploaded_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE famille DROP CONSTRAINT FK_2473F2133CEE3234');
        $this->addSql('DROP INDEX UNIQ_2473F2137E3C61F9');
        $this->addSql('DROP INDEX IDX_2473F2133CEE3234');
        $this->addSql('ALTER TABLE famille DROP family_group_id');
        $this->addSql('CREATE INDEX idx_2473f2137e3c61f9 ON famille (owner_id)');
    }
}
