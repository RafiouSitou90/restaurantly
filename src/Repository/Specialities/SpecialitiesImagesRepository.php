<?php

declare(strict_types=1);

namespace App\Repository\Specialities;

use App\Entity\Specialities\SpecialitiesImages;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<SpecialitiesImages> */
class SpecialitiesImagesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialitiesImages::class);
    }
}
