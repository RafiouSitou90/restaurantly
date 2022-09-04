<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220904203258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create categories table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_categories (id UUID NOT NULL, name VARCHAR(200) NOT NULL, slug VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_74BB3295E237E06 ON tab_categories (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_74BB329989D9B62 ON tab_categories (slug)');
        $this->addSql('CREATE INDEX search_idx ON tab_categories (name, slug) WHERE ((name IS NOT NULL) AND (slug IS NOT NULL))');
        $this->addSql('COMMENT ON COLUMN tab_categories.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE tab_categories');
    }
}
