<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Advert;
use AppBundle\Form\Type\AdvertType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    /**
     * @Route("/admin/advert/create", name="create advert")
     */
    public function createAdvertAction(Request $request)
    {
        $Advert = $this->getDoctrine()
            ->getRepository('AppBundle:Advert');
        $adverts = $Advert->ActiveAdverts(54);

        if (!$Advert)
        { throw
        $this->createNotFoundException( 'No Advert found' );
        }

        $advert = new Advert();
        $form = $this->createForm(new AdvertType(), $advert)
            ->add('save', 'submit', array(
                'label' => 'Create',
                'attr'=>array('class'=>'btn btn-md btn-info')
            ));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $advert->setSubscribeDate(new \DateTime());
            $advert->setExpired(0);
            $advert->setEnabled(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
            return $this->redirect($this->generateUrl('create advert'));
        }
        return $this->render('admin/advert.html.twig', array(
            'form' => $form ->createView(),
            'adverts'=>$adverts,
        ));
    }




    /**
     * @Route("admin/news/edit/{id}", name="manage news")
     */
    public function editAdvertAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $Advert  = $em->getRepository('AppBundle:Advert')->find($id);
        $rescentAdvert = $em->getRepository('AppBundle:Advert')->findAllRescentPublish('20');

        $request = $this->get('request');

        if (is_null($id)) {
            $postData = $request->get('news');
            $id = $postData['id'];
        }
        $form = $this->createForm(new AdvertType(), $Advert);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($Advert);
                $em->flush();
                return $this->redirect($this->generateUrl('create news'));
            }
        }
        return $this->render('admin/news.html.twig', array( 'form' => $form ->createView(), 'rescentAdvert'=>$rescentAdvert, ));
    }



}
