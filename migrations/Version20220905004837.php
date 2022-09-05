<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220905004837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create dishes table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_dishes (id UUID NOT NULL, category_id UUID NOT NULL, name VARCHAR(200) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(500) NOT NULL, content TEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9EC941512469DE2 ON tab_dishes (category_id)');
        $this->addSql('CREATE INDEX dish_search_idx ON tab_dishes (name, slug, summary) WHERE ((name IS NOT NULL) AND (slug IS NOT NULL) AND (summary IS NOT NULL))');
        $this->addSql('COMMENT ON COLUMN tab_dishes.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_dishes.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_dishes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tab_dishes ADD CONSTRAINT FK_F9EC941512469DE2 FOREIGN KEY (category_id) REFERENCES tab_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tab_dishes DROP CONSTRAINT FK_F9EC941512469DE2');
        $this->addSql('DROP TABLE tab_dishes');
    }
}
