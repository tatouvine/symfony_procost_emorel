<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findTotalCostByProject(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p as project')
            ->leftJoin('p.hourList', 'pt')
            ->leftJoin('pt.employ', 'e')
            ->addSelect('e,pt ,sum(pt.hours*e.hourlyCost) as total')
            ->groupBy('p.id')
            ->orderBy('p.creationDate', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }

    public function projectCountFinish()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p)')
            ->where('p.deliveryDate IS NOT NULL');

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function projectListFinish()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p as project')
            ->leftJoin('p.hourList', 'pt')
            ->leftJoin('pt.employ', 'e')
            ->addSelect('e,pt ,sum(pt.hours*e.hourlyCost) as total')
            ->where('p.deliveryDate IS NOT NULL')
            ->groupBy('p.id')
            ->orderBy('p.creationDate', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }

    public function projectCountNotFinish()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p)')
            ->where('p.deliveryDate IS NULL');
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findProjectByPage(int $page)
    {
        $qb = $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1)*10)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

    public function countProject()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(p)');
        return $qb->getQuery()->getOneOrNullResult();
    }
}
