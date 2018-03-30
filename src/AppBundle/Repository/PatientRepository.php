<?php

namespace AppBundle\Repository;

/**
 * PatientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PatientRepository extends \Doctrine\ORM\EntityRepository
{

    public function findLikeName($lastName)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.lastName LIKE :lastName')
            ->setParameter( 'lastName', "%$lastName%")
            ->orderBy('a.lastName')
            ->setMaxResults(5)
            ->getQuery()
            ->execute()
            ;
    }
}
