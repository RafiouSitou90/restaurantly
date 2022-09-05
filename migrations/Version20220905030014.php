<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220905030014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create events table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_events (id UUID NOT NULL, name VARCHAR(200) NOT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, summary VARCHAR(500) NOT NULL, content TEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX event_search_idx ON tab_events (name, slug, summary) WHERE ((name IS NOT NULL) AND (slug IS NOT NULL) AND (summary IS NOT NULL))');
        $this->addSql('COMMENT ON COLUMN tab_events.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_events.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE tab_events');
    }
}
