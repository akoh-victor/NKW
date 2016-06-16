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

    public function findDepartmentProduct($department,$limit=null, $minPrice=null,$maxPrice=null,$gender=null,$brand=null)
    {
        $query = $this ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->join('g.category', 'c')
            ->join('c.department', 'd')
            ->where('d = :department')
            ->setParameter('department', $department);

            if(!$minPrice == null){
                $query =  $query->andWhere('p.price >= :minPrice')
                       ->setParameter('minPrice',$minPrice);
            }
            if(!$maxPrice == null){
                $query = $query->andWhere('p.price <= :maxPrice')
                       ->setParameter('maxPrice',$maxPrice);
            }
            if(!$gender == null){
                $query = $query->andWhere('p.gender = :gender')
                       ->setParameter('gender',$gender);
            }

            if(!$brand == null){
                $query = $query->andWhere('p.brand = :brand')
                       ->setParameter('brand',$brand);
            }
        if(!$limit == null){
            $query = $query->setMaxResults($limit);
        }
        $query = $query ->getQuery()->getResult();

            return $query;

    }

    public function findCategoryProduct($category,$limit=null,$minPrice=null,$maxPrice=null,$gender=null,$brand=null)
    {

        $query = $this ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->join('g.category', 'c')
            ->where('c = :category')
            ->setParameter('category', $category);

            if(!$minPrice == null){
                $query =  $query->andWhere('p.price >= :minPrice')
                    ->setParameter('minPrice',$minPrice);
            }
            if(!$maxPrice == null){
                $query = $query->andWhere('p.price <= :maxPrice')
                    ->setParameter('maxPrice',$maxPrice);
            }
            if(!$gender == null){
                $query = $query->andWhere('p.gender = :gender')
                    ->setParameter('gender',$gender);
            }

            if(!$brand == null){
                $query = $query->andWhere('p.brand = :brand')
                    ->setParameter('brand',$brand);
            }
        if(!$limit == null){
            $query = $query->setMaxResults($limit);
        }
            $query = $query ->getQuery()->getResult();

            return $query;

    }


    public function findGroupProduct($group,$limit=null,$minPrice=null,$maxPrice=null,$gender=null,$brand=null)
    {

        $query = $this ->createQueryBuilder('l')
            ->select('p')
            ->from('AppBundle:Product','p')
            ->join('p.group', 'g')
            ->where('g = :group')
            ->setParameter('group', $group);

        if(!$minPrice == null){
            $query =  $query->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice',$minPrice);
        }
        if(!$maxPrice == null){
            $query = $query->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice',$maxPrice);
        }
        if(!$gender == null){
            $query = $query->andWhere('p.gender = :gender')
                ->setParameter('gender',$gender);
        }

        if(!$brand == null){
            $query = $query->andWhere('p.brand = :brand')
                ->setParameter('brand',$brand);
        }
        if(!$limit == null){
            $query = $query->setMaxResults($limit);
        }
        $query->orderBy('p.created', 'DESC');
        $query = $query ->getQuery()->getResult();

        return $query;
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
