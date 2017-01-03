<?php

namespace Marem\Bundle\CmsClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('marem_cms_client');

        $rootNode
            ->children()
                ->scalarNode('sulu_url')->cannotBeEmpty()->end()
                ->scalarNode('default_webspace')->end()
                ->arrayNode('navs')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('context')->end()
                            ->scalarNode('webspace')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('marketing_contents')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('url')->end()
                            ->scalarNode('uuid')->end()
                            ->scalarNode('webspace')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
