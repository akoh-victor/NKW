<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Akoh Ojochuma Victor <akoh.chuma@gmail.com>
 */




class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */


    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        //     $builder->add('content', null, array('required' => false));

        $builder
            ->add('brand','entity', array(
                'class'=>'AppBundle:Brand',
                'property'=>'name'
                 ))
            ->add('gender','entity', array(
                'class'=>'AppBundle:Gender',
                'property'=>'name'
            ))
            ->add('name', 'text', array('label' => 'Name','attr' => array('class'=>'form-control')))
            ->add('code', 'integer', array('label' => 'Product Code','attr' => array('class'=>'form-control')))
            ->add('openingQuantity', 'integer', array('label' => 'Opening Quantity','attr' => array('class'=>'form-control')))
            ->add('purchasePrice', 'money', array('label' => 'Purchase Price','required' => false,'attr' => array('class'=>'form-control')))
            ->add('price', 'money', array('label' => 'Price', 'attr' => array('class'=>'form-control')))
            ->add('manufactured', 'date', array(
                'label' => 'Manufactured',
                'required' => false
            ))
            ->add('expire', 'date', array(
                'label' => 'Expires',
                'required' => false
            ))
            ->add('visible','choice',array(
                'label' => 'Status',
                'choices' => array('1' => 'Visible', '0' => 'hidden'),
                'attr' => array('class'=>'form-control')
            ))
            ->add('frontImageFile', 'file', array('label' => 'Front Image', 'required' => false, 'attr' => array('class'=>'form-control')))
            ->add('rearImageFile', 'file', array('label' => 'Rear Image', 'required' => false, 'attr' => array('class'=>'form-control')))
            ->add('description', 'textarea', array(
                'attr' => array('cols' => 70,
                    'rows' => 1,'class'=>'form-control'),
                'label' => 'Description',
                'required' => false,
            ))
            ->add('about', 'textarea', array(
                'attr' => array('cols' => 70,'rows' => 1,'class'=>'form-control'),
                'label' => 'About',
                'required' => false,
            ));
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
        return 'app_product';
    }
}
