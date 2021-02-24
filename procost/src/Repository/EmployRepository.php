<?php

namespace App\Repository;

use App\Entity\Employ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employ[]    findAll()
 * @method Employ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employ::class);
    }

    public function findlengthEmploys()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p)');
        return $qb->getQuery()->getOneOrNullResult();
    }

}
