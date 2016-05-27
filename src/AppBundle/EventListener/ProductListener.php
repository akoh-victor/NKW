<?php
namespace AppBundle\EventListener;

use AppBundle\Event\ProductCreatedEvent;

use AppBundle\Entity\Groups;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible for creating the relationship
 * between brand and group on  product creation creation
 */
class ProductListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            ProductCreatedEvent::PRODUCT_CREATED =>'onCreationSuccess'
        );
    }


    /**
     * @param Event $event
     */
    public function onCreationSuccess(Event $event)
    {
          $product = $event->getProduct();
          $brand = $product->getBrand();
          $group =$product->getGroup();

            //check if there is a relationship btw brand and group
       if (!$group->hasBrand($brand))
       {
           $group->addBrand($brand);
       }

    }
}
