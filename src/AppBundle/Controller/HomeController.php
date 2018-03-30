<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 20/11/2017
 * Time: 13:55
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{

    /**
     * @Route("/home", name="home")
     */
    public function homeAction()
    {
        if ($this->container->get ( 'security.authorization_checker' )->isGranted ( 'IS_AUTHENTICATED_FULLY' )) {
        $user = $this->container->get ( 'security.token_storage' )->getToken ()->getUser ();
    }
        return $this->redirectToRoute('@App/Home/home.html.twig');
    }
}