<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function save(Employee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function filter($name, $startDate, $endDate, $inLeave): array
    {
        //I had a problem with match against functions in Query Builder, native query will be refactored soon.
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT DISTINCT(e.id), e.name, e.surname, ld.start_date, ld.end_date
                FROM employee as e
                LEFT JOIN leave_date as ld
                ON e.id = ld.employee_id
                WHERE (CONCAT(TRIM(e.name), TRIM(e.surname)) LIKE "%' . $name .  '%"
                OR MATCH(e.name, e.surname) AGAINST("' . $name  .'" IN BOOLEAN MODE))';

        if ($inLeave) {
            'AND ld.start_date <= "' . $startDate . '"
             AND ld.end_date >= "' . $endDate . '"';
        } else {
            'AND e.id NOT IN
                (
                    SELECT e.id
                    FROM employee as e
                    LEFT JOIN leave_date as ld
                    ON e.id = ld.employee_id
                    WHERE (CONCAT(TRIM(e.name), TRIM(e.surname)) LIKE "%' . $name .  '%"
                    OR MATCH(e.name, e.surname) AGAINST("' . $name  .'" IN BOOLEAN MODE))
                    AND ld.start_date <= "' . $startDate . '"
                    AND ld.end_date >= "' . $endDate . '"
     	        )';
        }

        $stmt = $conn->prepare($sql);

        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
