<?php
namespace AppBundle\Controller\checkout;

use FOS\UserBundle\Model\UserInterface;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderItem;
use Sylius\Bundle\OrderBundle\Controller\OrderItemController;
use Sylius\Component\Cart\Provider\CartProviderInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Finalize checkout step.
 * It builds the order from cart.
 *
 */
class FinalizeCheckoutStep extends Controller
{
    const STATE_BEGIN    = 'begin';
    const STATE_PENDING  = 'pending';
    const STATE_READY    = 'ready';
    const STATE_COMPLETE = 'complete';



    /**
     *  @Route("/checkout/finalize",name="checkout_summary")
     */
    public function summaryCheckoutAction(Request $request)
    {

        $order = $this->prepareOrder();

        return $this->render('checkout/step/finalize.html.twig', array(
            'order'=>$order,
        ));
    }


    /**
     *  @Route("/checkout/complete/{id}",name="checkout_complete")
     */
    public function completeOrderAction(Request $request, $id)
    {

        $this->verifySessionState($request->getSession(), self::STATE_BEGIN);

        $order = $this->getOrderRepository()->findOneBy(['id' => $id]);



        $user =$this->getUser();
        $order->setUser($user);
        $order->setState(self::STATE_PENDING);

        $this->get('event_dispatcher')->dispatch('app.product_ordered', new GenericEvent($order));
          // then save order
        $this->save($order);

        $this->addFlash('order.state', self::STATE_PENDING);
        $this->getProvider()->abandonCart();


        return $this->redirectToRoute('showProfileActivities');


    }


    /**
     * Prepares order.
     *
     *
     *
     * if the shipping and address is implemented this is where to clue it to the order
     *
     * @return OrderInterface
     */
    private function prepareOrder()
    {

        $orderBuilder = $this->build();
        $this->addFlash('order.state', self::STATE_BEGIN);
        $this->container->get('event_dispatcher')->dispatch('sylius.order.pre_create', new GenericEvent($orderBuilder));

        return $orderBuilder;
    }


    /**
     * gets the cart and and recalculate the to total
     * and perform other building functions
     */
    public function build()
    {
        /**
         * gets the cart
         */
        $cart = $this-> getProvider()->getCart();

       if ($cart->isEmpty())
       {
            throw new \LogicException('The cart must not be empty.');
       }

        $order=$cart;

        $order->recalculateItemsTotal();
        return $order;
    }




    /**
     * Get cart provider.
     *
     * @return CartProviderInterface
     */
    protected function getProvider()
    {
        return $this->container->get('sylius.cart_provider');
    }

    /**
     * Get order repository.
     *
     */
    protected function getOrderRepository()
    {
        return $this->get('sylius.repository.order');
    }

    /**
     * Saves the Order.
     */
    public function save(OrderInterface $order)
    {
        $manager= $this->get('sylius.manager.order');

        $manager->persist($order);
        $manager->flush();
    }

    /**
     * Prevent direct access, and quietly redirect to checkout_summary.
     *
     * @param Session $session
     * @param string  $state
     */
    private function verifySessionState(Session $session, $state)
    {
        $flashBag = $session->getFlashBag();

        if (
            !$flashBag->has('order.state')
            || !in_array($state, $flashBag->peek('order.state', []))
        ) {
            $this->redirectToRoute('checkout_summary');
        } else {
            $flashBag->get('order.state');
        }

    }
}
