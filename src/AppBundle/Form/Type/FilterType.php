<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Akoh Ojochuma Victor <akoh.chuma@gmail.com>
 */




class FilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('gender','entity', array(
                'class'=>'AppBundle:Gender',
                'property'=>'name'
            ))
            ->add('brand','entity', array(
                'class'=>'AppBundle:Brand',
                'property'=>'name'
            ))
            ->add('price', 'money', array('label' => 'Min Price', 'attr' => array('class'=>'form-control')))
            ->add('price', 'money', array('label' => 'Max Price', 'attr' => array('class'=>'form-control')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        // Best Practice: use 'app_' as the prefix of your custom form types names
        // see http://symfony.com/doc/current/best_practices/forms.html#custom-form-field-types
        return 'app_search';
    }
}
