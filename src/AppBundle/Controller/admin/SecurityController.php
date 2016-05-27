<?php

namespace AppBundle\Controller\admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
 {
	
	
    /**
     * @Route("/logdin", name="login_rout")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
           // get the login error if there is one
           $error = $authenticationUtils->getLastAuthenticationError();
           // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render( 'security/login.html.twig', array(
        // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );



       
    	    
     }
    


/**
 * @Route("/login_check", name="login_check")
 */

    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
 }
