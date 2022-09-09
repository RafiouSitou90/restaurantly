<?php

declare(strict_types=1);

namespace App\Repository\Events;

use App\Entity\Events\Events;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<Events> */
class EventsRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }
}
