<?php

namespace App\Repository;

use App\Entity\LeaveDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LeaveDate>
 *
 * @method LeaveDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeaveDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeaveDate[]    findAll()
 * @method LeaveDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeaveDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LeaveDate::class);
    }

    public function save(LeaveDate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
