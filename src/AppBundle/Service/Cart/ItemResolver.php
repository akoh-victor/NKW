<?php
namespace AppBundle\Service\Cart;

use Sylius\Component\Cart\Model\CartItemInterface;
use Sylius\Component\Cart\Resolver\ItemResolverInterface;
use Sylius\Component\Cart\Resolver\ItemResolvingException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;

class ItemResolver implements ItemResolverInterface
{
    /**
     * Entity Manager.
     *
     * @var EntityManager
     */
    private $entityManager;
    /**
     * Form factory.
     *
     * @var FormFactory
     */
    private $formFactory;

    /**
     * Constructor.
     *
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     */
    public function __construct( EntityManager $entityManager,FormFactory $formFactory ){
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    public function resolve(CartItemInterface $item, $request)
    {
        $productId = $request->query->get('productId');

        // If no product id given, or product not found, we throw exception with nice message.
        if (!$productId || !$product = $this->getProductRepository()->find($productId)) {
            throw new ItemResolvingException('Requested product was not found. Report this to chuma@nimikiddies.com');
        }
        $product = $this->getProductRepository()->find($productId);

        $dataclass ='AppBundle\Entity\OrderItem';

        $this->isStockAvailable($product);


        $form = $this->formFactory->create('sylius_cart_item', null, array('data_class' => $dataclass ));

        $form->bind($request);
        $item = $form->getData(); // Item instance,
        // Assign the product to the item and define the unit price.
        $item->setProduct($product);
        $item->setUnitPrice($product->getPrice());




        // If all is ok with form, quantity and other stuff, simply return the item.
        if ($form->isValid()) {
            return $item;
        }

    }


    private function isStockAvailable($product)
    {
    }

    private function getProductRepository()
    {
        return $this->entityManager->getRepository('AppBundle:Product');
    }
}