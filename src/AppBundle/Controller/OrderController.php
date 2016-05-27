<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use AppBundle\Entity\OrderItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use    Pagerfanta\Pagerfanta;
use    Pagerfanta\Adapter\DoctrineORMAdapter;
use    Pagerfanta\Exception\NotValidCurrentPageException;

class OrderController extends Controller
{
    const STATE_BEGIN    = 'begin';
    const STATE_COMPLETE = 'complete';
    const STATE_READY    = 'ready';


    /**
     *  @Route("/checkout/{page}",
     *          name="checkout-order",
     *         requirements={"page" = "\d+"},
     *         defaults={"page" = "1"})
     */
    public function beginOrderForProductAction(Request $request)
    {
        //BEFRORE PLACEING ORDER USER MUST BE A USER (CUSTOMER)

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        //USER MUST HAVE ROLE CUSTOMER TO PLACE ORDER
        $this->denyAccessUnlessGranted('ROLE_CUSTOMER', null, 'Unable to access this page! You must be customer to
        access');





        return $this->render('AppBundle::begin_order_for_download.html.twig', [

        ]);
    }

}