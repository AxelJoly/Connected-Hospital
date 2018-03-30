<?php

/**
 * Created by PhpStorm.
 * User: axel
 * Date: 15/02/2018
 * Time: 14:13
 */

namespace AppBundle\Services;
use \Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class ChartData
{
    private $em;


    public function __construct(EntityManager $em){
        $this->em = $em;
    }


    /**
     * Request patient patient's data and return formated array of data
     * @param $id
     * @return array of data
     */
    public function getData($id){

        $temp = array();
        $date = new \DateTime("now");
        $date->setTimezone(new \DateTimeZone("Europe/Paris"));
        $date->modify("-2 hours");

        $qb = $this->em->createQueryBuilder();
        $data = $qb->select('e')
            ->from('AppBundle:Data', 'e')
            ->join('e.patient', 'patient' )
            ->where('patient.id = :id')
            ->andWhere('e.date >= :date')
            ->setParameters(['date' => $date, 'id' => $id])
            ->orderBy('e.date', 'DESC')
            ->getQuery()
            ->getResult();

        if (count($data) > 5){
            foreach ($data as $item) {
                array_push($temp, [$item->getDate(), $item->getBPM(), $item->getGlycemia(), $item->getTemperature(), $item->getBloodPressure()]);
            }

            return $temp;
        }

    }
}