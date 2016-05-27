<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(



            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),

            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            new Sylius\Bundle\MoneyBundle\SyliusMoneyBundle(),
            new Sylius\Bundle\SequenceBundle\SyliusSequenceBundle(),
            new Sylius\Bundle\OrderBundle\SyliusOrderBundle(),

            new Sylius\Bundle\CartBundle\SyliusCartBundle(),
           // new Sylius\Bundle\ProductBundle\SyliusProductBundle(),
           // new Sylius\Bundle\ArchetypeBundle\SyliusArchetypeBundle(),
            //new Sylius\Bundle\AttributeBundle\SyliusAttributeBundle(),
           // new Sylius\Bundle\AssociationBundle\SyliusAssociationBundle(),
           // new Sylius\Bundle\VariationBundle\SyliusVariationBundle(),

            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new PUGX\MultiUserBundle\PUGXMultiUserBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),

            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new AppBundle\AppBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
