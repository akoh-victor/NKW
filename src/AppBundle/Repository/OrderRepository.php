<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Bundle\OrderBundle\Doctrine\ORM\OrderRepository  as BaseRepository;

/**
 * OrderRepository
 *
 */
class OrderRepository extends  BaseRepository
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


}
