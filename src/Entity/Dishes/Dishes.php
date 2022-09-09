<?php

declare(strict_types=1);

namespace App\Entity\Dishes;

use App\Entity\AbstractBaseEntity;
use App\Entity\Categories\Categories;
use App\Repository\Dishes\DishesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Table(name: 'tab_dishes')]
#[ORM\Entity(repositoryClass: DishesRepository::class)]
#[ORM\Index(columns: ['name', 'slug', 'summary'], name: 'dish_search_idx',
    options: [
        "where" => "((name IS NOT NULL) AND (slug IS NOT NULL) AND (summary IS NOT NULL))",
    ],
)]
class Dishes extends AbstractBaseEntity
{
    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 500)]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(precision: 12, scale: 2)]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'dishes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[Vich\UploadableField(mapping: 'dish_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    /** @var Collection<int, DishesImages>  */
    #[ORM\OneToMany(mappedBy: 'dish', targetEntity: DishesImages::class, orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if ($imageFile !== null) {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName = null): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize = null): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /** @return Collection<int, DishesImages> */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(DishesImages $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setDish($this);
        }

        return $this;
    }

    public function removeImage(DishesImages $image): self
    {
        if ($this->images->removeElement($image) && $image->getDish() === $this) {
            $image->setDish(null);
        }

        return $this;
    }
}
