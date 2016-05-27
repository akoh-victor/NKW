<?php
namespace AppBundle\Entity;

use Sylius\Component\Cart\Model\Cart as SyliusCart;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_order")
 */
class Order extends SyliusCart
{
    /**
     * @ORM\Column(type="string",nullable = true)
     */
    private $user;


    //relationship
    /**
     *  @ORM\OneToMany(targetEntity="Sylius\Component\Order\Model\OrderItemInterface", mappedBy="order")
     */
    protected $items;

    /**
     *  @ORM\OneToMany(targetEntity="Sylius\Component\Order\Model\AdjustmentInterface", mappedBy="order")
     */
    protected $adjustments;


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set user
     *
     * @param string $user
     * @return Order
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }
}
