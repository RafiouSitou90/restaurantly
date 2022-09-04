<?php

declare(strict_types=1);

namespace App\Entity\Categories;

use App\Entity\AbstractBaseEntity;
use App\Repository\Categories\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tab_categories')]
#[ORM\Index(columns: ['name', 'slug'], name: 'search_idx',
    options: [
        "where" => "((name IS NOT NULL) AND (slug IS NOT NULL))",
    ],
)]
#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories extends AbstractBaseEntity
{
    #[ORM\Column(type: 'string', length: 200, unique: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $slug = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
