<?php

namespace AppBundle\Controller\admin;

use AppBundle\Form\Type\BadgeType;
use AppBundle\Entity\Badge;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BadgeController extends Controller
 {
        /**
         * @Route("/admin/badge/create", name="create badge")
         */
        public function createBadgeAction(Request $request)
        {
            $Advert = $this->getDoctrine()
                ->getRepository('AppBundle:Badge');
            $rescentAdvert = $Advert->findAll();

            if (!$Advert)
            { throw
            $this->createNotFoundException( 'No Advert found' );
            }

            $badge = new Badge();
            $form = $this->createForm(new BadgeType(), $badge)
                ->add('save', 'submit', array(
                    'label' => 'Create',
                    'attr'=>array('class'=>'btn btn-md btn-info')
                ));
            $form->handleRequest($request);

            if ($form->isValid()) {


                $badge->setEnable(1);

                $em = $this->getDoctrine()->getManager();
                $em->persist($badge);
                $em->flush();
                return $this->redirect($this->generateUrl('create badge'));
            }
            return $this->render('admin/badge.html.twig', array(
                'form' => $form ->createView(),
                'badges'=>$rescentAdvert,

            ));
        }
}


