<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220906024323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create chefs socials table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_chefs_socials (id UUID NOT NULL, chef_id UUID NOT NULL, type VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2A71448150A48F1 ON tab_chefs_socials (chef_id)');
        $this->addSql('COMMENT ON COLUMN tab_chefs_socials.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_chefs_socials.chef_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_chefs_socials.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tab_chefs_socials ADD CONSTRAINT FK_2A71448150A48F1 FOREIGN KEY (chef_id) REFERENCES tab_chefs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tab_chefs_socials DROP CONSTRAINT FK_2A71448150A48F1');
        $this->addSql('DROP TABLE tab_chefs_socials');
    }
}
