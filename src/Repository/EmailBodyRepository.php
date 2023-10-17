<?php

namespace App\Repository;

use App\Entity\EmailBody;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmailBody>
 *
 * @method EmailBody|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailBody|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailBody[]    findAll()
 * @method EmailBody[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailBodyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailBody::class);
    }

//    /**
//     * @return EmailBody[] Returns an array of EmailBody objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EmailBody
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
