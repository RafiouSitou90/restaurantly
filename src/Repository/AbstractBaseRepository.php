<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AbstractBaseEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template E of object
 *
 * @method object|null find($id, $lockMode = null, $lockVersion = null)
 * @method object|null findOneBy(array $criteria, array $orderBy = null)
 * @method object[]    findAll()
 * @method object[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<E>
 */
abstract class AbstractBaseRepository extends ServiceEntityRepository
{
    public function add(AbstractBaseEntity $entity, bool $flush = false): void
    {
        if ($entity->getId() === null) {
            $this->getEntityManager()->persist($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractBaseEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
