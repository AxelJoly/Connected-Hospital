<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 30/03/2018
 * Time: 11:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Configuration;
use AppBundle\Forms\managePatientFormType;
use AppBundle\Forms\manageRaspberryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaspberryController extends Controller
{
    /**
     * @Route("/listRaspberry", name="listRaspberry")
     */
    public function RaspberryListAction(Request $request) {

        $raspberries = $this->getDoctrine()->getRepository('AppBundle:Configuration')->findAll();

        return $this->render ( 'AppBundle:Patient:listRaspeberry.html.twig', array (
            'raspberries' => $raspberries
        ) );
    }

    /**
     * @Route("/modifyRaspberry/{id}", name="modifyRaspberry")
     */
    public function showProfileAction(Request $request, $id)
    {
        $config = $this->getDoctrine()->getRepository('AppBundle:Configuration')->find($id);
        $form = $this->createForm ( manageRaspberryFormType::class, $config );

        $form->handleRequest ( $request );

        if ($form->isSubmitted () && $form->isValid ()) {
            $em = $this->getDoctrine ()->getManager ();
            $em->persist ( $config );
            $em->flush ();

            return $this->redirectToRoute ( 'homepage' );
        }
        return $this->render('AppBundle:Patient:modifyRaspberry.html.twig', array (
            'form' => $form->createView (),
            'name' => $config->getName()
        ));
    }
}