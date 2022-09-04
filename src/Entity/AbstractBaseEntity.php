<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractBaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected ?Uuid $id = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected ?DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTimeInterface $updatedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /** @codeCoverageIgnore */
    public function setUpdatedAt(?DateTimeInterface $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /** @codeCoverageIgnore */
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /** @codeCoverageIgnore */
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTime();
    }
}
