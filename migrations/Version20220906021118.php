<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220906021118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create chefs table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_chefs (id UUID NOT NULL, title VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX chef_search_idx ON tab_chefs (first_name, last_name) WHERE ((first_name IS NOT NULL) AND (last_name IS NOT NULL))');
        $this->addSql('COMMENT ON COLUMN tab_chefs.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_chefs.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE tab_chefs');
    }
}
