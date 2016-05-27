<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Brand;

use AppBundle\Form\Type\BrandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BrandController extends Controller
{
    /**
     * @Route("/admin/brand/create", name="create brand")
     */
    public function brandCreateAction(Request $request)
    {
        $Brand = $this->getDoctrine()->getRepository('AppBundle:Brand');

        $brandim =  $Brand->find(5);

        $brand = new Brand();
        $form = $this->createForm(new BrandType(), $brand)
            ->add('save', 'submit', array(
                'label' => 'Save',
                'attr'=>array('class'=>'btn btn-md btn-info')

            ));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();
            return $this->redirect($this->generateUrl('create brand'));
        }


        return $this->render('admin/brand.html.twig', array(
            'form' => $form ->createView(),
            'brands'=>$brandim

        ));
    }


}
