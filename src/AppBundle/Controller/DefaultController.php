<?php

namespace AppBundle\Controller;

use Sylius\Bundle\CartBundle\Form\Type\CartItemType;

use AppBundle\Entity\Message;
use AppBundle\Form\Type\MessageType;
use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Department;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;


use Symfony\Component\HttpFoundation\Response;

class DefaultController extends  Controller
{


    /**
     * @Route("/", name = "home")
     */
    public function indexAction(Request $request)
    {
        $limit = 8;
        $Badge = $this->getDoctrine()->getRepository('AppBundle:Badge');
        $Product = $this->getDoctrine()->getRepository('AppBundle:Product');
        $Category = $this->getDoctrine()->getRepository('AppBundle:Category');
        $Department = $this->getDoctrine()->getRepository('AppBundle:Department');
        $Advert = $this->getDoctrine()->getRepository('AppBundle:Advert');
        //$mostRead=$Product->mostView('20');
       // $newArrivals = $Product->findAllRecentProducts('15');

        $newArrivals = $Product->findAllRecentProducts('15');
        $featuredProducts = $Product->findAllRecentProducts('15');
        $sponsoredProducts = $Product->findAllRecentProducts('15');
        $departments=$Department->findDepartment($limit);
        $categories=$Category->findAllvisable();
        $badges = $Badge->findAll();
        $adverts = $Advert->find(1);



        return $this->render('default/index.html.twig', array(
            'newArrivals' => $newArrivals,
            'featuredProducts' => $featuredProducts,
            'sponsoredProducts' => $sponsoredProducts,
            'departments'=>$departments,
            'badges'=>$badges,
            'categories'=>$categories,
            'adverts'=> $adverts

        ));
    }

    /**
     * @Route("/admin", name = "admin")
     */
    public function adminIndexAction(Request $request)
    {

        $Department = $this->getDoctrine()->getRepository('AppBundle:Department');
        $departments = $Department->findAllOrderedById();



        return $this->render('admin/index.html.twig', array(
        'departments'=>$departments,
        ));
    }




    /**
     * @Route("/department/{id}", name = "department")
     */
    public function departmentAction(Request $request,$id)
    {
        $Department = $this->getDoctrine()->getRepository('AppBundle:Department');
        $Product = $this->getDoctrine()->getRepository('AppBundle:Product');
        $Gender = $this->getDoctrine()->getRepository('AppBundle:Gender');
        $Brand = $this->getDoctrine()->getRepository('AppBundle:Brand');


        $department = $Department->find($id);
        $departments = $Department->findDepartment('8');;
        $customersChoiceProducts = $Product->mostView('20');

        /*
         * Receive the requested value from the form as request
         */
        $filter = $request;

        $session = $filter->getSession();

        $query =  $Product->findDepartmentProduct($department);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query,$request->query->getInt('page', 1),10,array('distinct' => false));


        return $this->render('default/department.html.twig', array(
            'pagination' => $pagination,
            'department'=>$department,
            'departments'=>$departments,
            'customersChoiceProducts'=>$customersChoiceProducts,

        ));
    }

    /**
     * @Route("/department/category/{categoryId}", name = "category")
     */
    public function categoryAction(Request $request,$categoryId)
    {
        $Department = $this->getDoctrine()->getRepository('AppBundle:Department');
        $Category = $this->getDoctrine()->getRepository('AppBundle:Category');
        $category = $Category->find($categoryId);
        $departments = $Department->findDepartment(8);;

        $Product = $this->getDoctrine()->getRepository('AppBundle:Product');
        $customersChoiceProducts = $Product->mostView('20');

        $query =  $Product->findCategoryProduct($category);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query,$request->query->getInt('page', 1),10,array('distinct' => false));

        return $this->render('default/category.html.twig', array(
            'pagination' => $pagination,
            'category'=>$category,
            'departments'=>$departments,
            'customersChoiceProducts'=>$customersChoiceProducts,
        ));
    }

    /**
     * @Route("/department/category/group/{groupId}", name = "group")
     */
    public function groupAction(Request $request,$groupId)
    {
        $Group = $this->getDoctrine()->getRepository('AppBundle:Group');
        $group = $Group->find($groupId);

        $Product = $this->getDoctrine()->getRepository('AppBundle:Product');
        $customersChoiceProducts = $Product->mostView('20');

        $Department = $this->getDoctrine()->getRepository('AppBundle:Department');
        $departments = $Department->findDepartment(8);



        $query =  $Product->findGroupProduct($group);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            25/*limit per page*/
        );

        return $this->render('default/group.html.twig', array(
            'pagination' => $pagination,
            'departments'=>$departments,
            'group'=>$group,
            'customersChoiceProducts'=>$customersChoiceProducts,
        ));
    }

    /**
     * @Route("/admin/email", name = "email")
     */
    public function checkemailAction(Request $request)
    {

        return $this->render('admin/email.html.twig', array());

    }


    /**
     * @Route("/brows/{id}", name="brows product")
     */
    public function browsProductAction(Request $request,$id)
    {

        $Product = $this->getDoctrine()->getRepository('AppBundle:Product');
        $product = $Product->find($id);

        $customersChoiceProducts = $Product->mostView('20');
        $sponsoredProducts = $Product->findAllRecentProducts('15');
        $similarProducts = $Product->findAllRecentProducts('15');

        if ($product) {

            $curView = $product->getView();
            $upView = $curView + 1;
            $product->setView($upView);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

        }

        $dataclas ='AppBundle\Entity\OrderItem';
        return $this->render('default/brows.html.twig', array(

            'selectedProduct' =>  $product,
            'customersChoiceProducts' => $customersChoiceProducts,
            'sponsoredProducts' => $sponsoredProducts,
            'similarProducts'=>$similarProducts,
            'dataclase'=>$dataclas



        ));
    }

    /**
     * @Route("/contact", name = "contactUs")
     */
    public function contactAction(Request $request)
    {

        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $message->setPosted(new \DateTime());
            $message->setView(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice','Your message was successfully sent !!! We will get back to you soon.');
            return $this->redirect($this->generateUrl('contactUs'));
        }


        return $this->render('default/contact.html.twig', array( 'form' => $form ->createView(),));

    }
}