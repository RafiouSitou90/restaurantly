<?php

declare(strict_types=1);

namespace App\Repository\Categories;

use App\Entity\Categories\Categories;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<Categories> */
class CategoriesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }
}
