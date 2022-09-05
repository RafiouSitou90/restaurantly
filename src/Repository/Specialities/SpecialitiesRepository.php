<?php

declare(strict_types=1);

namespace App\Repository\Specialities;

use App\Entity\Specialities\Specialities;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<Specialities> */
class SpecialitiesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialities::class);
    }
}
