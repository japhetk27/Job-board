<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PeopleRepository extends EntityRepository
{
    // Vous pouvez ajouter des méthodes spécifiques à votre entité User ici
    // Par exemple, des méthodes pour effectuer des requêtes personnalisées.

    public function findByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
