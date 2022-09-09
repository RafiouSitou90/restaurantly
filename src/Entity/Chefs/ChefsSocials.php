<?php

declare(strict_types=1);

namespace App\Entity\Chefs;

use App\Entity\AbstractBaseEntity;
use App\Enums\ChefSocialEnum;
use App\Repository\Chefs\ChefsSocialsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tab_chefs_socials')]
#[ORM\Entity(repositoryClass: ChefsSocialsRepository::class)]
class ChefsSocials extends AbstractBaseEntity
{
    #[ORM\Column(length: 50, enumType: ChefSocialEnum::class)]
    private ChefSocialEnum $type = ChefSocialEnum::CHEF_SOCIAL_OTHER;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'socials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chefs $chef = null;

    public function getType(): ?ChefSocialEnum
    {
        return $this->type;
    }

    public function setType(ChefSocialEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getChef(): ?Chefs
    {
        return $this->chef;
    }

    public function setChef(?Chefs $chef): self
    {
        $this->chef = $chef;

        return $this;
    }
}
