<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
use AppBundle\Entity\EncryptedPatient;
use AppBundle\Entity\Patient;
use AppBundle\Forms\createUserType;
use AppBundle\Forms\SearchPatientType;
use AppBundle\Repository\PatientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }


        return $this->render('AppBundle:Home:home.html.twig', array (

        ) );
    }

    /**
     * @Route("/search-patient", name="search_patient", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function searchAction(PatientRepository $repo, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $qs = $request->query->get('q', $request->query->get('term', ''));
        $patients = $repo->findLikeName($qs);

        return $this->render('@App/Search/search.json.twig', ['patients' => $patients]);
    }

    /**
     * @Route("/get-patient/{id}", name="get_patient", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function getAction(int $id = null, PatientRepository $repo): Response
    {
        if (null === $author = $repo->find($id)) {
            throw $this->createNotFoundException();
        }

        return $this->json($author->getLastName());
    }


    /**
     * @Route("/show", name="show")
     */
    public function showAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Patient:show.html.twig');
    }

    /**
     * @Route("/showProfile/{id}", name="showProfile")
     */
    public function showProfileAction(Request $request, $id)
    {
        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);
        // replace this example code with whatever you need

        $patientDecrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $patient));

        $this->decrypt($patient, $patientDecrypted);
        return $this->render('AppBundle:Patient:patientProfile.html.twig', array (
            'patientId' => $id,
            'patient' => $patient
        ));
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
