<?php

namespace Dwo\FlaggingManagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dwo_flagging_manager');

        $rootNode
            ->children()

                ->scalarNode('manager')->defaultValue('dwo_flagging_manager.manager.feature.db')->end()
                ->scalarNode('index_template')->defaultValue('DwoFlaggingManagerBundle::index.html.twig')->end()

                ->arrayNode('database')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('connection')->defaultValue('doctrine.dbal.default_connection')->end()
                        ->scalarNode('table')->defaultValue('features')->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}