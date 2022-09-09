<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220905010619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create dishes images table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tab_dishes_images (id UUID NOT NULL, dish_id UUID NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BC77CD26148EB0CB ON tab_dishes_images (dish_id)');
        $this->addSql('COMMENT ON COLUMN tab_dishes_images.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_dishes_images.dish_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tab_dishes_images.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tab_dishes_images ADD CONSTRAINT FK_BC77CD26148EB0CB FOREIGN KEY (dish_id) REFERENCES tab_dishes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tab_dishes_images DROP CONSTRAINT FK_BC77CD26148EB0CB');
        $this->addSql('DROP TABLE tab_dishes_images');
    }
}
