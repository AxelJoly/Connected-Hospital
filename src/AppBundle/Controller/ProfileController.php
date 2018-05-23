<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 01/02/2018
 * Time: 10:29
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EncryptedPatient;
use AppBundle\Entity\Patient;
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
        $patientDecrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $patient));
        $this->decrypt($patient, $patientDecrypted);
        if($patient->getSeat()){
            $state = 1;
        }else{
            $state = 0;
        }
        return $this->render ( 'AppBundle:Patient:profile.html.twig', array (
            'profile' => $patient, 'state' => $state
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

    public function decrypt(Patient $user, EncryptedPatient $encryptedPatient){
        $privateKey = openssl_get_privatekey(file_get_contents($this->get('kernel')->getRootDir(). '/config/private.key'));

        $result = openssl_open(base64_decode($user->getFirstName()), $decryptedData, base64_decode($encryptedPatient->getFirstName()), $privateKey);
        $user->setFirstName($decryptedData);

        $result = openssl_open(base64_decode($user->getLastName()), $decryptedData, base64_decode($encryptedPatient->getLastName()), $privateKey);
        $user->setLastName($decryptedData);

        $result = openssl_open(base64_decode($user->getRelativePhone()), $decryptedData, base64_decode($encryptedPatient->getRelativePhone()), $privateKey);
        $user->setRelativePhone($decryptedData);

        $result = openssl_open(base64_decode($user->getDescription()), $decryptedData, base64_decode($encryptedPatient->getDescription()), $privateKey);
        $user->setDescription($decryptedData);

// Show if it was a success or failure

    }
}