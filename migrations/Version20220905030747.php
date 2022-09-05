<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220905030747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create events images table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_events_images (id UUID NOT NULL, event_id UUID NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EF8B4ED371F7E88B ON tab_events_images (event_id)');
        $this->addSql('COMMENT ON COLUMN tab_events_images.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_events_images.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_events_images.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tab_events_images ADD CONSTRAINT FK_EF8B4ED371F7E88B FOREIGN KEY (event_id) REFERENCES tab_events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tab_events_images DROP CONSTRAINT FK_EF8B4ED371F7E88B');
        $this->addSql('DROP TABLE tab_events_images');
    }
}
