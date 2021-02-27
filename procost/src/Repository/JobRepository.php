<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function findAllJobAndPosibilityToDelete(int $page)
    {
        $value = ($page - 1) * 10;
        $sql = 'SELECT *,(SELECT COUNT(*) FROM employ WHERE job_id =Job.id) as numberJobUse
          FROM JOB LIMIT 10 OFFSET '.$value;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function countJob()
    {
        $qb = $this->createQueryBuilder('j')
            ->select('count(j)');
        return $qb->getQuery()->getOneOrNullResult();
    }
}
