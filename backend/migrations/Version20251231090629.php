<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251231090629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE famille (id SERIAL NOT NULL, owner_id INT NOT NULL, theme_id INT NOT NULL, avatar VARCHAR(255) NOT NULL, family_role VARCHAR(50) NOT NULL, has_calendar_access BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2473F2137E3C61F9 ON famille (owner_id)');
        $this->addSql('CREATE INDEX IDX_2473F21359027487 ON famille (theme_id)');
        $this->addSql('CREATE TABLE theme (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, background_image VARCHAR(255) NOT NULL, primary_color VARCHAR(7) NOT NULL, secondary_color VARCHAR(7) NOT NULL, music_url VARCHAR(255) DEFAULT NULL, video_url VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE famille ADD CONSTRAINT FK_2473F2137E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE famille ADD CONSTRAINT FK_2473F21359027487 FOREIGN KEY (theme_id) REFERENCES theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE door ADD available_date DATE DEFAULT \'2025-12-01\'');
        $this->addSql('UPDATE door SET available_date = (\'2025-12-\' || LPAD(day_number::text, 2, \'0\'))::DATE');
        $this->addSql('ALTER TABLE door ALTER COLUMN available_date SET NOT NULL');
        $this->addSql('ALTER TABLE door ALTER COLUMN available_date DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE famille DROP CONSTRAINT FK_2473F2137E3C61F9');
        $this->addSql('ALTER TABLE famille DROP CONSTRAINT FK_2473F21359027487');
        $this->addSql('DROP TABLE famille');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE door DROP available_date');
    }
}
