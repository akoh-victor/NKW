<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Group;
use AppBundle\Entity\Category;
use AppBundle\Entity\Department;
use AppBundle\Form\Type\GroupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class GroupController extends Controller
{
    /**
     * @Route("/admin/group/create/{category_id}", name="create category group")
     */
    public function categoryGroupCreateAction(Request $request,$category_id)
    {

        $Category = $this->getDoctrine()->getRepository('AppBundle:Category');
        $Group = $this->getDoctrine()->getRepository('AppBundle:Group');

        $category =  $Category->findOneById($category_id);
        $groups = $Group->findCategoryGroup($category,10);
        $group = new Group();

        $form = $this->createForm(new GroupType(), $group)
            ->add('save', 'submit', array(
                'label' => 'Save',
                'attr'=>array('class'=>'btn btn-md btn-info')
            ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            // am using the id as position until i upgrade to generating new position
            $curPosition = $group->getId();

            $group->setPosition($curPosition);
            $group->setCategory($category);
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            return $this->redirect($this->generateUrl('create category group',
                array('category_id' => $category_id, )));
        }

        return $this->render('admin/group.html.twig', array(
            'form' => $form ->createView(),
            'groups'=>$groups,
        ));
    }

}