<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Patient;
use Doctrine\ORM\NonUniqueResultException;

/**
 * EncryptedPatientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EncryptedPatientRepository extends \Doctrine\ORM\EntityRepository
{

    public function findPatient(Patient $patient){
        $query = $this->getEntityManager()->createQuery('SELECT encryptedPatient 
                                              FROM AppBundle\Entity\EncryptedPatient encryptedPatient 
                                              JOIN encryptedPatient.patient p 
                                              WITH p.id = :patient');
        $query->setParameters ( array (
                'patient' => $patient->getId()
            )
        );
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
        }
    }
}
