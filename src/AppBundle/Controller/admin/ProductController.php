<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Product;

use AppBundle\EventListener\ProductListener;
use AppBundle\Event\ProductCreatedEvent;
use AppBundle\Form\Type\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;



class ProductController extends Controller
{
    /**
     * @Route("/admin/product/create/{group_id}", name="create group product")
     */
    public function groupProductCreateAction(Request $request,$group_id)
    {

        $dispatcher = new EventDispatcher();
        $listener = new ProductListener();


        $Group = $this->getDoctrine()->getRepository('AppBundle:Group');
        $group =  $Group->findOneById($group_id);
        $product = new Product();

        $form = $this->createForm(new ProductType(), $product)
            ->add('save', 'submit', array(
                'label' => 'Save',
                'attr'=>array('class'=>'btn btn-md btn-info')
            ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $openingStock = $product->getOpeningQuantity();
            $openingPrice = $product->getPrice();
            $product->setOrder(0);
            $product->setStock($openingStock);
            $product->setEntry(new \DateTime());
            $product->setCreated(new \DateTime());
            $product->setOpeningPrice($openingPrice);
            $product->setDiscontinue(0);
            $product->setView(0);
            $product->setGroup($group);

            //create product created event and passed in product as the event object
            $event = new ProductCreatedEvent($product);
            // add listener to the event
            $dispatcher->addListener(ProductCreatedEvent::PRODUCT_CREATED, array($listener, 'onCreationSuccess'));
            //dispatch event
            $dispatcher->dispatch(ProductCreatedEvent::PRODUCT_CREATED, $event);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();


            return $this->redirect($this->generateUrl('create group product',
                array('group_id' => $group_id, )));
        }

        return $this->render('admin/product.html.twig', array(
            'form' => $form ->createView(),
            'group'=>$group,
        ));
    }

}