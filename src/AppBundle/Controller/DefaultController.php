<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Doctor;
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

        $form = $this->createForm ( SearchPatientType::class );

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {}

        return $this->render('AppBundle:Home:home.html.twig', array (
            'form' => $form->createView ()
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
        // replace this example code with whatever you need
        return $this->render('AppBundle:Patient:patientProfile.html.twig', array (
            'patientId' => $id
        ));
    }


}
