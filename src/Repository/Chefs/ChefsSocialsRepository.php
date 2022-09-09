<?php

declare(strict_types=1);

namespace App\Repository\Chefs;

use App\Entity\Chefs\ChefsSocials;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<ChefsSocials> */
class ChefsSocialsRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChefsSocials::class);
    }
}
