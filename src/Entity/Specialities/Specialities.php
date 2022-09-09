<?php

declare(strict_types=1);

namespace App\Entity\Specialities;

use App\Entity\AbstractBaseEntity;
use App\Repository\Specialities\SpecialitiesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Table(name: 'tab_specialities')]
#[ORM\Entity(repositoryClass: SpecialitiesRepository::class)]
#[ORM\Index(columns: ['name', 'slug', 'summary'], name: 'speciality_search_idx',
    options: [
        "where" => "((name IS NOT NULL) AND (slug IS NOT NULL) AND (summary IS NOT NULL))",
    ],
)]
class Specialities extends AbstractBaseEntity
{
    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 500)]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[Vich\UploadableField(mapping: 'speciality_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    /** @var Collection<int, SpecialitiesImages> */
    #[ORM\OneToMany(mappedBy: 'speciality', targetEntity: SpecialitiesImages::class, orphanRemoval: true)]
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

    /** @return Collection<int, SpecialitiesImages> */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(SpecialitiesImages $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setSpeciality($this);
        }

        return $this;
    }

    public function removeImage(SpecialitiesImages $image): self
    {
        if ($this->images->removeElement($image) && $image->getSpeciality() === $this) {
            $image->setSpeciality(null);
        }

        return $this;
    }
}
