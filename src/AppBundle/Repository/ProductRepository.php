<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;

/**
 * ProductRepository
 *
 */
class ProductRepository extends EntityRepository
    {

    public function findDepartmentProduct($department)
    {
        return $this
            ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->join('g.category', 'c')
            ->join('c.department', 'd')
            ->where('d = :department')
            ->setParameter('department', $department)
            ->getQuery()
            ->getResult();

    }

    public function findCategoryProduct($category)
    {
        return $this
            ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->join('g.category', 'c')
            ->where('c = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }


    public function findGroupProduct($group)
    {
        return $this
            ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->where('g = :group')
            ->setParameter('group', $group)
            ->getQuery()
            ->getResult();
    }

    public function findBrandProduct($brand)
    {
        return $this
            ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.brand', 'b')
            ->where('b = :brand')
            ->setParameter('brand', $brand)
            ->getQuery()
            ->getResult();
    }






    public function findPositionedNews($position,$limit)
       {
		return $this
		 ->createQueryBuilder('n')
            ->select('n')
            ->where('n.position = :position')
            ->andWhere('n.expire = :no')
            ->setParameter('no',0)
            ->setParameter('position', $position)
            ->setMaxResults($limit)
            ->getQuery()
			->getResult();
       }
    public function findAllRecentProducts($limit) {
        return $this
            ->createQueryBuilder('e')
            ->select('e')
            ->where('e.created <= :now')
            ->andWhere('e.discontinue = :no')
            ->setParameter('no',0)
            ->setParameter('now', new \DateTime())
            ->orderBy('e.created', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function importantNews($limit)
    {
        return $this
            ->createQueryBuilder('n')
            ->select('n')
            ->orderBy('n.priorit', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function moreNews($catId,$limit)
    {
        return $this
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.category = :catId')
            ->andWhere('n.expire = :no')
            ->setParameter('no',0)
            ->setParameter('catId', $catId)
            ->orderBy('n.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

    }

    public function badgeNews($limit)
    {
        return $this
            ->createQueryBuilder('n')
            ->select('n')
            ->Where('n.expire = :no')
            ->setParameter('no',0)
            ->orderBy('n.priority', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

    }
    public function mostView($limit){
        return $this
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.view >= :view')
            ->andWhere('n.expire = :no')
            ->setParameter('no',0)
            ->setParameter('view', 1)
            ->orderBy('n.view', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    public function departmentMostView($departmentId,$limit){
        return $this
            ->createQueryBuilder('n')
            ->select('n')
            ->where('n.view >= :view')
            ->andWhere('n.discontinue = :no')
            ->andWhere('n.department_id = :dept_id')
            ->setParameter('no',0)
            ->setParameter('dept_id', $departmentId)
            ->setParameter('view', 1)
            ->orderBy('n.view', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

     public function findNext($limit,$id)
     {
         return $this
             ->createQueryBuilder('n')
             ->select('n')
             ->where('n.id' > ':id')
             ->andWhere('n.expire = :no')
             ->setParameter('no',0)
             ->setParameter('id',$id)
             ->orderBy('n.id', 'ASC')
             ->setMaxResults($limit)
             ->getQuery()
             ->getResult();
     }




}
