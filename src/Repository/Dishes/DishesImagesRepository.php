<?php

declare(strict_types=1);

namespace App\Repository\Dishes;

use App\Entity\Dishes\DishesImages;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<DishesImages> */
class DishesImagesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DishesImages::class);
    }
}
