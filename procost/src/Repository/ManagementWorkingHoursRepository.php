<?php

namespace App\Repository;

use App\Entity\ManagementWorkingHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ManagementWorkingHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManagementWorkingHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManagementWorkingHours[]    findAll()
 * @method ManagementWorkingHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagementWorkingHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManagementWorkingHours::class);
    }

    public function findAllValue($id)
    {
        $qb = $this->createQueryBuilder('m')
            ->addSelect('e')
            ->addSelect('p')
            ->leftJoin('m.employ', 'e')
            ->leftJoin('m.project', 'p')
            ->where('m.employ = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }

    public function findValuePersonByProject($id)
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.project = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }

    public function findFiveLastCreateInformation()
    {
        $qb = $this->createQueryBuilder('m')
            ->orderBy('m.creationDate', 'DESC')
            ->setMaxResults(5);
        return $qb->getQuery()->getResult();
    }

    public function findPersonneHaveWorkByProject($id)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('(sum(m.hours)*e.hourlyCost) as cost')
            ->innerJoin('m.employ', 'e')
            ->where('m.project = :id')
            ->setParameter('id', $id)
            ->groupBy('m.employ');
        return $qb->getQuery()->getResult();
    }

    public function countHours()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('sum(m.hours) as allHours');
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function bestEmploy()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('(sum(m.hours)*e.hourlyCost) as cost')
            ->addSelect('m as value')
            ->innerJoin('m.employ', 'e')
            ->groupBy('m.employ')
            ->orderBy('cost', 'DESC')
            ->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
