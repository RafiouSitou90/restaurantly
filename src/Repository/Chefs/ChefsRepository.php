<?php

declare(strict_types=1);

namespace App\Repository\Chefs;

use App\Entity\Chefs\Chefs;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<Chefs> */
class ChefsRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chefs::class);
    }
}
