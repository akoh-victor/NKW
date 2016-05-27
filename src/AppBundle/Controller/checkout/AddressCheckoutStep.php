<?php

namespace AppBundle\Controller\checkout;

use AppBundle\EventListener\UserUpdateListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * The addressing step of checkout.
 * User is redirected to update account with the billing address and continue
 *
 */
class AddressCheckoutStep extends Controller
{

    /**
     *  @Route("/checkout/address",name="checkout_address")
     */
    public function AddressingCheckoutAction(Request $request)
    {


        $user = $this->getUser();
        /**
         * If the user in logged in and has role customer
         * redirect to the next checkout step(address)
         */
        if ($this->isAccountUpdated() )
        {
            return $this->redirectToRoute('checkout_summary');
        }




        /**
         * If there is need to handle the login and registration in checkout process it wil be handled
         * here.
         * and it will use the template
         *
         *but for now it will use the fos updating address system
         */
        $user = $this->getUser();


        /**
         * @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface
         */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /**
         * @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface
         */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('checkout_summary');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('checkout/step/addressing.html.twig', array(
            'form' => $form->createView()
        ));

    }



    public function isAccountUpdated()
    {
        $user = $this->getUser();

          if ($user->getUpdated()){
            return  true;
          }
    }

}
