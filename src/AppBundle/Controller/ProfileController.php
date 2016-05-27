<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as baseProfiler;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
class ProfileController extends baseProfiler
{
    /**
     * @Route("/profile", name="showProfile")
     */
    public function showProfileAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }


        $url="/profile/account.html.twig";

        return $this->render('default/profile.html.twig', array(
            'user' => $user,
            'default'=>$url

        ));
    }




    /**
     * @Route("/profile/account/{link}", defaults={"link" = "personalInfo"},name="showProfileAccount")
     */
    public function showAccountAction(Request $request,$link)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $this->denyAccessUnlessGranted('ROLE_CUSTOMER', null, 'Unable to access this page! You must be customer to
        access');



        $url = $request->query->get('url');

        return $this->render('default/profile.html.twig', array(
            'user' => $user,
            'account'=>$url,
            'link' => $link,


        ));
    }
    /**
     * @Route("/profile/activities/{link}", defaults={"link" = "order"}, name="showProfileActivities")
     */
    public function showActivityAction(Request $request,$link)
    {
         $user = $this->getUser();

        $cart=$this->container->get('sylius.cart_provider')->getCart();
        $order =$this->get('sylius.repository.order')->find(['user' => $user]);

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $this->denyAccessUnlessGranted('ROLE_CUSTOMER', null, 'Unable to access this page! You must be customer to
        access');
        $url="1";
        return $this->render('default/profile.html.twig', array(
            'user' => $user,
            'activities' =>$url,
            'link' => $link,
            'orders' => $order,
        ));
    }
}