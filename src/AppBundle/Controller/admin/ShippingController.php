<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Shipping;
use AppBundle\Form\Type\ShippingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShippingController extends Controller
{
    /**
     * @Route("/admin/shipping/create", name="create_shipping")
     */
    public function shippingCreateAction(Request $request)
    {
        $Shipping = $this->getDoctrine()->getRepository('AppBundle:Shipping');

        $shippings =  $Shipping->find(5);

        $shipping = new Shipping();
        $form = $this->createForm(new ShippingType(), $shipping)
            ->add('save', 'submit', array(
                'label' => 'Save',
                'attr'=>array('class'=>'btn btn-md btn-info')

            ));
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($shipping);
            $em->flush();
            return $this->redirect($this->generateUrl('create_shipping'));
        }
        return $this->render('admin/shipping.html.twig', array(
            'form' => $form ->createView(),
            'shipping'=>$shippings

        ));
    }


}
