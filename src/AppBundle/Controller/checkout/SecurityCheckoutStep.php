<?php

namespace AppBundle\Controller\checkout;

use AppBundle\Entity\Order;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Security step.
 *
 * If user is not logged in, displays login & registration form.
 *
 */
class SecurityCheckoutStep extends Controller
{

    /**
     *  @Route("/checkout/",name="begin_checkout")
     */
    public function securityCheckoutAction(Request $request)
    {


        /**
         * If the user in logged in and has role customer
         * redirect to the next checkout step(address)
         */
        if ( ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) && ($this->get
            ('security.authorization_checker')->isGranted('ROLE_CUSTOMER'))   )
        {

            return $this->redirectToRoute('checkout_address');

        }
        /**
         * If there is need to handle the login and registration in checkout process it wil be handled
         * here.
         * and it will use the template
         * checkout/step/security.html.twig',
         *
         * but for now it will use the fos login and registration  system so this function"securityCheckoutAction"
         * will neva return 'checkout/step/security.html.twig',
         */
        return $this->render('checkout/step/security.html.twig', array(

        ));
    }

}
