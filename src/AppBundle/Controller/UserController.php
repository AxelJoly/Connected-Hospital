<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 20/11/2017
 * Time: 10:53
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Doctor;
use AppBundle\Entity\EncryptedPatient;
use AppBundle\Forms\createUserType;
use AppBundle\Forms\createPatientFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Patient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Forms\managePatientFormType;

class UserController extends Controller
{
    /**
     * @Route("/login", name="app.login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $username = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Login:login.html.twig', array(
            'username' => $username,
            'error' => $error
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request) {
        $user = new Doctor();
        $user->setRoles ( [
            "ROLE_ADMIN"
        ] );
        $form = $this->createForm ( createUserType::class, $user );

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {

            // HASH du password
            $plainPassword = $user->getPassword ();
            $encoder = $this->container->get ( 'security.password_encoder' );
            $encoded = $encoder->encodePassword ( $user, $plainPassword );

            $user->setPassword ( $encoded );

            $em = $this->getDoctrine ()->getManager ();
            $em->persist ( $user );
            $em->flush ();

            return $this->redirectToRoute ( 'home' );
        }

        return $this->render ( 'AppBundle:User:register.html.twig', array (
            'form' => $form->createView ()
        ) );
    }

    /**
     * @Route("/addPatient", name="addPatient")
     * @Security("has_role('ROLE_ADMIN','ROLE_USER')")
     */
    public function addPatientAction(Request $request) {



        $patient = new Patient();
        $keyCrypted = new EncryptedPatient();
        $form = $this->createForm ( createPatientFormType::class, $patient );

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {

            $encryptedData = $this->encrypt($patient, $keyCrypted);
            dump($patient);
            dump($keyCrypted);
            $em = $this->getDoctrine ()->getManager ();
            $keyCrypted->setPatient($patient);
            $em->persist ($patient);
            $em->persist( $keyCrypted);
            $em->flush ();

            return $this->redirectToRoute ( 'home' );
        }

        return $this->render ( 'AppBundle:Patient:addPatient.html.twig', array (
            'form' => $form->createView ()
        ) );
    }

    /**
     * @Route("/managePatient/{id}", name="managePatient")
     * @Security("has_role('ROLE_ADMIN','ROLE_USER')")
     */
    public function managePatientAction(Request $request, $id) {

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $patient = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);
        $keyCrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $patient));
        $this->decrypt($patient, $keyCrypted);


        $form = $this->createForm (managePatientFormType::class, $patient);

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {

            $encryptedData = $this->encrypt($patient, $keyCrypted);

            $em = $this->getDoctrine ()->getManager ();
            $keyCrypted->setPatient($patient);
            $em->persist ($patient);
            $em->persist( $keyCrypted);
            $em->flush ();

            return $this->redirectToRoute ( 'home' );
        }

        return $this->render ( 'AppBundle:Patient:managePatient.html.twig', array (
            'form' => $form->createView ()
        ) );
    }

    /**
     * @Route("/logout", name="app.logout")
     */
    public function logoutAction()
    {
       
    }

    /**
     * @Route("/patientList", name="patientList")
     */
    public function patientListAction(Request $request) {

        $patients = $this->getDoctrine()->getRepository('AppBundle:Patient')->findAll();
        $patientsDecrypted = array();
        foreach($patients as $patient){
            $keyCrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $patient));
            $this->decrypt($patient, $keyCrypted);
            array_push($patientsDecrypted, $patient);
        }

        return $this->render ( 'AppBundle:Patient:patientList.html.twig', array (
            'patients' => $patientsDecrypted
        ) );
    }

    /**
     * @Route("/patientList/encrypted", name="patientListEncrypted")
     */
    public function patientListEncryptedAction(Request $request) {

        $patients = $this->getDoctrine()->getRepository('AppBundle:Patient')->findAll();


        return $this->render ( 'AppBundle:Patient:patientList.html.twig', array (
            'patients' => $patients
        ) );
    }

    public function encrypt(Patient $patient, EncryptedPatient $encryptedPatient){


        $publicKeys[] = openssl_get_publickey(file_get_contents($this->get('kernel')->getRootDir(). '/config/public.pem'));

        // Encrypt the $fullText and return the $encryptedText and the $encryptedKeys
        $res1 = openssl_seal($patient->getLastName(), $encryptedText, $encryptedKeys1, $publicKeys);
        $patient->setLastName(base64_encode($encryptedText));
        $encryptedPatient->setLastName(base64_encode($encryptedKeys1[0]));

        $res2 = openssl_seal($patient->getFirstName(), $encryptedText, $encryptedKeys2, $publicKeys);
        $patient->setFirstName(base64_encode($encryptedText));
        $encryptedPatient->setFirstName(base64_encode($encryptedKeys2[0]));

        $res3 = openssl_seal($patient->getRelativePhone(), $encryptedText, $encryptedKeys3, $publicKeys);
        $patient->setRelativePhone(base64_encode($encryptedText));
        $encryptedPatient->setRelativePhone(base64_encode($encryptedKeys3[0]));

        $res4 = openssl_seal($patient->getDescription(), $encryptedText, $encryptedKeys4, $publicKeys);
        $patient->setDescription(base64_encode($encryptedText));
        $encryptedPatient->setDescription(base64_encode($encryptedKeys4[0]));


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