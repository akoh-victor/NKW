<?php

namespace AppBundle\Entity;

use Sylius\Component\Cart\Model\CartItem as SyliusCartItem;
use Doctrine\ORM\Mapping as ORM;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity
 * @ORM\Table(name="app_order_item")
 */
class OrderItem extends SyliusCartItem
{
    /**
     * @var Product
     */
    private $product;



    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

}
