<?php

namespace Marem\Bundle\CmsClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\VarDumper\VarDumper;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MaremSuluClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('marem_cms_client.parameter.sulu_url', $config['sulu_url']);
        $container->setParameter('marem_cms_client.parameter.default_webspace', $config['default_webspace']);
        $container->setParameter('marem_cms_client.parameter.navs', $config['navs']);
        $container->setParameter('marem_cms_client.parameter.marketing_contents', $config['marketing_contents']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
