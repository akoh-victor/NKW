<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\EventListener\UserUpdateListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * The addressing step of checkout.
 * User is redirected to update account with the billing address and continue
 *
 */
class SearchController extends Controller
{

    /**
     *  @Route("/search",name="search")
     */
    public function SearchProductAction(Request $request)
    {

        $request = $this->getRequest();
          $data = $request->request->get('data');
        $scope = $request->request->get('scope');
        echo  trim($data);
        echo  trim($scope);
        $em = $this->getDoctrine()->getManager();


        if($scope==0){

            $result = $em ->getRepository("AppBundle:Product")->createQueryBuilder('n')
                ->select('n')
                ->where('n.name LIKE :data')
                ->andWhere('n.visible = :yes')
                ->setParameter('yes',1)
                ->setParameter('data','%'.$data.'%')
                ->getQuery()
                ->getResult();

        }elseif($scope>0){

       $result = $em ->getRepository("AppBundle:Product")->createQueryBuilder('n')
           ->select('n')
           ->join('n.group', 'g')
           ->join('g.category', 'c')
           ->where('n.name LIKE :data')
           ->andWhere('n.visible = :yes')
           ->andWhere('c = :scope')
           ->setParameter('yes',1)
           ->setParameter('data','%'.$data.'%')
           ->setParameter('scope',$scope)
           ->getQuery()
           ->getResult();

        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $result, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            30/*limit per page*/
        );


        return $this->render('default/search.html.twig', array(

            'data'=>$data,
            'scope'=>$scope,
            'pagination'=>$pagination
        ));

    }
}
