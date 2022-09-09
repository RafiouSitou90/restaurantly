<?php

declare(strict_types=1);

namespace App\Repository\Events;

use App\Entity\Events\EventsImages;
use App\Repository\AbstractBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends AbstractBaseRepository<EventsImages> */
class EventsImagesRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsImages::class);
    }
}
