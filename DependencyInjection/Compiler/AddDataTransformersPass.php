<?php
namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AddDataTransformersPass implements CompilerPassInterface {
	
    public function process(ContainerBuilder $container) {

        if (!$container->hasDefinition('yjv.report_rendering.data_transformer_registry')) {
			
			return;
		}
		
		$dataTransformerRegistry = $container->getDefinition('yjv.report_rendering.data_transformer_registry');
		
		foreach ($container->findTaggedServiceIds('yjv.report_rendering.data_transformer') as $id => $tags) {
		
			$tag = $tags[0];
			
			if (!isset($tag['alias'])) {
			    
			    throw new \RuntimeException(sprintf('service "%s" tagged "yjv.report_rendering_data_transformer" must have an alias attribute', $id));
			}
		    
		    $dataTransformerRegistry->addMethodCall('set', array($tag['alias'], new Reference($id)));
		}
	}
}
