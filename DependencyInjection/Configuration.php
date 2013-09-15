<?php

namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('yjv_report_rendering')
            ->children()
                ->arrayNode('id_generator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('id')
                            ->defaultValue('yjv.report_rendering.id_generator')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('filter_values')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('id')
                            ->defaultValue('yjv.report_rendering.filters')
                        ->end()
                        ->scalarNode('session_key')
                            ->defaultValue('report_filters')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('filter_values_listeners')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->enumNode('type')
                                ->cannotBeEmpty()
                                ->isRequired()
                                ->values(array(
                                    'post',
                                    'endpoint',
                                    'custom'
                                ))
                            ->end()
                            ->scalarNode('request_matcher_id')->cannotBeEmpty()->end()
                            ->scalarNode('filter_loader_id')->cannotBeEmpty()->end()
                            ->scalarNode('response_generator_id')->cannotBeEmpty()->end()
                            ->scalarNode('filter_data_path')->cannotBeEmpty()->defaultValue('report_filters')->end()
                            ->scalarNode('path')->cannotBeEmpty()->defaultValue('/report-filters')->end()
                            ->scalarNode('attribute')->cannotBeEmpty()->defaultValue('request')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
