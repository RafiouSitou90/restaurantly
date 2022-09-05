<?php

declare(strict_types=1);

namespace App\Repository\Dishes;

use App\Entity\Dishes\Dishes;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<Dishes> */
class DishesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dishes::class);
    }
}
