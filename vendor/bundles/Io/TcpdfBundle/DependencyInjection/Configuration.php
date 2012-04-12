<?php

namespace Io\TcpdfBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('io_tcpdf');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
                    ->addDefaultsIfNotSet()
                    ->children()
//                        ->variableNode('type')->defaultValue('memcache')->end()
//                        ->variableNode('host')->defaultValue('localhost')->end()
//                        ->variableNode('lib_path')->defaultValue('vendor/tcpdf')->end()
                        ->variableNode('instance_class')->defaultValue('TCPDF')->end()
                        ->variableNode('class')->defaultValue('Io\TcpdfBundle\Helper\Tcpdf')->end()

                    ->end()
        ;

        return $treeBuilder;
    }
}
