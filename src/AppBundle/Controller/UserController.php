<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 20/11/2017
 * Time: 10:53
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Doctor;
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

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $user = new Patient();
        $form = $this->createForm ( createPatientFormType::class, $user );

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {

            $em = $this->getDoctrine ()->getManager ();
            $user->setEffectiveDate();
            $user->setReleaseDate();
            $em->persist ( $user );
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

        $user = $this->getDoctrine()->getRepository('AppBundle:Patient')->find($id);

        $form = $this->createForm (managePatientFormType::class, $user);

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {

            $em = $this->getDoctrine ()->getManager ();

            $em->persist ( $user );
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

}