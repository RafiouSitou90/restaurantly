<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220905014022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create specialities images table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_specialities_images (id UUID NOT NULL, speciality_id UUID NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5D6833BA3B5A08D7 ON tab_specialities_images (speciality_id)');
        $this->addSql('COMMENT ON COLUMN tab_specialities_images.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_specialities_images.speciality_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_specialities_images.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tab_specialities_images ADD CONSTRAINT FK_5D6833BA3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES tab_specialities (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tab_specialities_images DROP CONSTRAINT FK_5D6833BA3B5A08D7');
        $this->addSql('DROP TABLE tab_specialities_images');
    }
}
