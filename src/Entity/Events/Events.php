<?php

declare(strict_types=1);

namespace App\Entity\Events;

use App\Entity\AbstractBaseEntity;
use App\Enums\EventEnum;
use App\Repository\Events\EventsRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Table(name: 'tab_events')]
#[ORM\Entity(repositoryClass: EventsRepository::class)]
#[ORM\Index(columns: ['name', 'slug', 'summary'], name: 'event_search_idx',
    options: [
        "where" => "((name IS NOT NULL) AND (slug IS NOT NULL) AND (summary IS NOT NULL))",
    ],
)]
class Events extends AbstractBaseEntity
{
    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 50, enumType: EventEnum::class)]
    private EventEnum $type = EventEnum::EVENT_UNKNOWN_PARTIES;

    #[ORM\Column(length: 500)]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private ?float $price = null;

    #[Vich\UploadableField(mapping: 'event_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

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

    public function getType(): ?EventEnum
    {
        return $this->type;
    }

    public function setType(EventEnum $type): self
    {
        $this->type = $type;

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
}
