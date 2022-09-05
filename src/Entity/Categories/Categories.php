<?php

declare(strict_types=1);

namespace App\Entity\Categories;

use App\Entity\AbstractBaseEntity;
use App\Entity\Dishes\Dishes;
use App\Repository\Categories\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tab_categories')]
#[ORM\Index(columns: ['name', 'slug'], name: 'category_search_idx',
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

    /** @var Collection<int, Dishes> */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Dishes::class, orphanRemoval: true)]
    private Collection $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }

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

    /** @return Collection<int, Dishes> */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dishes $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setCategory($this);
        }

        return $this;
    }

    public function removeDish(Dishes $dish): self
    {
        if ($this->dishes->removeElement($dish) && $dish->getCategory() === $this) {
            $dish->setCategory(null);
        }

        return $this;
    }
}
