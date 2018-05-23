<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\Data;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("api/patient", defaults={"_format" ="json"})
 */
class PatientController extends FOSRestController
{
    /**
     * @Route("/pat")
     * @Get()
     * @View(serializerGroups={"details"})
     * @ApiDoc(
     *     section = "Patient",
     *     description="Return patients",
     *     output={"class" = "AppBundle\Entity\Patient", "collection" = true, "groups"={"details"}}
     * )
     */
    public function listAction()
    {

        $pat_tab = $this->getDoctrine()->getRepository('AppBundle:Data')->findAll();
        return $pat_tab;
    }


    /**
     * @Route("/graphData{id}")
     * @Get()
     * @View(serializerGroups={"details"})
     * @ApiDoc(
     *     section = "Patient",
     *     description="Return patients",
     *     output={"class" = "AppBundle\Entity\Patient", "collection" = true, "groups"={"details"}}
     * )
     */
    public function profileAction($id)
    {

        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);
        $pat_tab = $this->getDoctrine()->getRepository('AppBundle:Data')->findBy(array('patient' => $patient), array('idData' => 'DESC'), $limit = 20);
       
        return $pat_tab;
    }
}
