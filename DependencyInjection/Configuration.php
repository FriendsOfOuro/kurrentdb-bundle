<?php
namespace EventStore\Bundle\ClientBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('event_store_client');

        $rootNode
            ->children()
                ->scalarNode('base_url')
                    ->cannotBeEmpty()
                    ->defaultValue('http://127.0.0.1:2113')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
