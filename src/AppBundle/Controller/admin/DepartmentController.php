<?php

namespace AppBundle\Controller\admin;

use AppBundle\Entity\Department;

use AppBundle\Form\Type\DepartmentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class DepartmentController extends Controller
{
    /**
     * @Route("/admin/department/create", name="create department")
     */
    public function departmentCreateAction(Request $request)
    {
        $department = new Department();
        $form = $this->createForm(new DepartmentType(), $department)
        ->add('save', 'submit', array(
        'label' => 'Save',
        'attr'=>array('class'=>'btn btn-md btn-info')

          ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            // am using the id as position until i upgrade to generating new position
            $curPosition = $department->getId();
            $department->setPosition( $curPosition);
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();
            return $this->redirect($this->generateUrl('create department'));
        }

        return $this->render('admin/department.html.twig', array(
            'form' => $form ->createView()
        ));
    }



    /**
     * @Route("admin/department/edit/{id}", name="edit_department")
     */
    public function departmentEditAction($id){

        $em = $this->getDoctrine()->getEntityManager();
        $department  = $em->getRepository('AppBundle:Department')->find($id);
        //$allnews =$em->getRepository('AppBundle:Department')->findAll();


            $request = $this->get('request');

            if (is_null($id)) {
                $postData = $request->get('department');
                $id = $postData['id'];
            }

            $form = $this->createForm(new DepartmentType(), $department)
                ->add('save', 'submit', array(
                    'label' => 'Update',
                    'attr'=>array('class'=>'btn btn-md btn-info')

                ));

            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($department);
                    $em->flush();

                    return $this->redirect($this->generateUrl('admin'));
                }
            }

        return $this->render('admin/department.html.twig', array(
            'form' => $form ->createView(),
        ));
    }





}