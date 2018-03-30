<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 01/02/2018
 * Time: 10:29
 */

namespace AppBundle\Controller;

use AppBundle\Services\ChartData;
use AppBundle\Services\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use AppBundle\Entity\Data;


class ProfileController extends Controller
{
   /**
    * @Route("/patient/{id}", name="patientProfile")
    * @Security("has_role('ROLE_ADMIN','ROLE_USER')")
    */
    public function profileAction($id)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);

        return $this->render ( 'AppBundle:Patient:profile.html.twig', array (
            'profile' => $patient
        ) );
    }

    /**
     * @Route("/charts/{id}", name="charts")
     * @Security("has_role('ROLE_ADMIN','ROLE_USER')")
     */
    public function chartAction($id)
    {   if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
    }
        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);
        $em = $this->getDoctrine ()->getManager();
        $chartData = new ChartData($em);

        $chart = new Chart($chartData);

        if ($chart->chartBuilder($id) == null){
            $state = false;
        }else{
            $state = true;
        }


        return $this->render('AppBundle:Patient:charts.html.twig', array('piechart' => $chart->chartBuilder($id), 'state' => $state, 'profile' => $patient));
    }
}