<?php

namespace App\Repository;

use App\Entity\JobApplications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobApplications>
 *
 * @method JobApplications|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobApplications|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobApplications[]    findAll()
 * @method JobApplications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobApplicationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobApplications::class);
    }

//    /**
//     * @return JobApplications[] Returns an array of JobApplications objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobApplications
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
