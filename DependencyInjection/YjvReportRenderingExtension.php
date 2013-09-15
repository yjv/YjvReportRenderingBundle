<?php

namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\DefinitionDecorator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class YjvReportRenderingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('data_transformers.yml');
        $loader->load('columns.yml');
        $loader->load('renderers.yml');
        $loader->load('reports.yml');
        
        if ($config['id_generator']['id'] != 'yjv.report_rendering.id_generator') {
            
            $container->setAlias('yjv.report_rendering.id_generator', $config['id_generator']['id']);
            $container->removeDefinition('yjv.report_rendering.id_generator_prefix_listener');
        }
        
        if ($config['filter_values']['id'] != 'yjv.report_rendering.filters') {
            
            $container->setAlias('yjv.report_rendering.filters', $config['filter_values']['id']);
        } else {
            $container
                ->getDefinition('yjv.report_rendering.filters')
                ->replaceArgument(1, $config['filter_values']['session_key'])
            ;
        }
        
        foreach ($config['filter_values_listeners'] as $name => $listenerConfig) {
            
            $this->buildFilterValuesListener($container, $name, $listenerConfig);
        }
    }
    
    protected function buildFilterValuesListener(ContainerBuilder $container, $name, array $listenerConfig)
    {
        $requestMatcherId = sprintf('yjv.report_rendering.filter_values_listener.%s.request_matcher', $name);
        $filterLoaderId = sprintf('yjv.report_rendering.filter_values_listener.%s.filter_loader', $name);
        $responseGeneratorId = sprintf('yjv.report_rendering.filter_values_listener.%s.response_generator', $name);

        switch ($listenerConfig['type']) {
            case 'post':
                $container
                    ->register(
                        $requestMatcherId, 
                        $container->getParameter('yjv.report_rendering.request_matcher.class')
                    )
                    ->setArguments(array(null, null, array('POST')))
                ;
                $container
                    ->register(
                        $filterLoaderId, 
                        $container->getParameter('yjv.report_rendering.parameter_bag_loader.class')
                    )
                    ->setArguments(array(
                        $listenerConfig['attribute'], 
                        $listenerConfig['filter_data_path']
                    ))
                ;
                $responseGeneratorId = null;
                break;
            case 'endpoint':
                $container
                    ->register(
                        $requestMatcherId, 
                        $container->getParameter('yjv.report_rendering.request_matcher.class')
                    )
                    ->setArguments(array($listenerConfig['path'], null, array('POST')))
                ;
                $container
                    ->register(
                        $filterLoaderId, 
                        $container->getParameter('yjv.report_rendering.parameter_bag_loader.class')
                    )
                    ->setArguments(array($listenerConfig['attribute'], $listenerConfig['filter_data_path']))
                ;
                $container->register(
                    $responseGeneratorId, 
                    $container->getParameter('yjv.report_rendering.success_response_generator.class')
                );
                break;
            case 'custom':
            default:
                $requestMatcherId = $listenerConfig['request_matcher_id'];
                $filterLoaderId = $listenerConfig['filter_loader_id'];
                $responseGeneratorId = isset($listenerConfig['response_generator_id']) ? $listenerConfig['response_generator_id'] : null;
                break;
        }
        
        $listener = new DefinitionDecorator('yjv.report_rendering.abstract_filter_values_listener');
        $listener->setArguments(array(
            new Reference('yjv.report_rendering.filters'), 
            new Reference($requestMatcherId), 
            new Reference($filterLoaderId)
        ))
        ->addTag('kernel.event_subscriber');
        
        if ($responseGeneratorId) {
            
            $listener->addMethodCall(
                'setResponseGenerator', 
                array(new Reference($responseGeneratorId))
            );
        }
        
        $container->setDefinition(
            sprintf('yjv.report_rendering.filter_values_listener.%s', $name), 
            $listener
        );
    }
}
