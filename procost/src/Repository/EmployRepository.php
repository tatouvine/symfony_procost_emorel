<?php

namespace App\Repository;

use App\Entity\Employ;
use App\Entity\Src\Store\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
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

    public function findEmployByPage(int $page)
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('j')
            ->leftJoin('e.job', 'j')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

    public function countEmploys()
    {
        $qb = $this->createQueryBuilder('e')
            ->select('count(e)');
        return $qb->getQuery()->getOneOrNullResult();
    }
}
