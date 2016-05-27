<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Akoh Ojochuma Victor <akoh.chuma@gmail.com>
 */

class ShippingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
	

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('method', 'text', array('label' => 'Method','attr' => array('class'=>'form-control')));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Shipping',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        // see http://symfony.com/doc/current/best_practices/forms.html#custom-form-field-types
        return 'app_shipping';
    }
}
