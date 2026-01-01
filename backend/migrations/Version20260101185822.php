<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260101185822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo (id SERIAL NOT NULL, door_opening_id INT NOT NULL, filename VARCHAR(255) NOT NULL, caption TEXT DEFAULT NULL, uploaded_at VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14B784186AA96033 ON photo (door_opening_id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784186AA96033 FOREIGN KEY (door_opening_id) REFERENCES door_opening (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT FK_14B784186AA96033');
        $this->addSql('DROP TABLE photo');
    }
}
