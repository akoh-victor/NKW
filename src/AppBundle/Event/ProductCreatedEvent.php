<?php
namespace AppBundle\Event;

use AppBundle\Entity\Product;
use Symfony\Component\EventDispatcher\Event;

/**
 * The product created event is dispatched each time an product is created
 * in the system.
 * for the the listners to carry out post product creation actions
 */
class ProductCreatedEvent extends Event
{
    const PRODUCT_CREATED = 'product.created';

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

}