<?php
namespace Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AddTypesPass implements CompilerPassInterface {
	
	protected $extensions = array();
    
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }
    
    public function process(ContainerBuilder $container) {

		foreach ($this->extensions as $extensionName => $tagNames) {
		    
            if (!$container->hasDefinition($extensionName)) {
    			
    			return;
    		}
    		
    		$tagNames = (array)$tagNames;
    		
    		$typeTag = array_shift($tagNames);
    		$typeExtensionTag = array_shift($tagNames);
    		
    		$extension = $container->getDefinition($extensionName);
    		
    		$this->addTaggedServices($container, $extension, $typeTag, 'addType');
    		
    		if ($typeExtensionTag) {
    		    
        		$this->addTaggedServices($container, $extension, $typeExtensionTag, 'addTypeExtension');
    		}
		}
	}
	
	protected function addTaggedServices(ContainerBuilder $container, Definition $extension, $tagName, $methodCall)
	{
		
		foreach ($container->findTaggedServiceIds($tagName) as $id => $tags) {
			
			$tag = $tags[0];
			
			if (!isset($tag['alias'])) {
			    
			    throw new \RuntimeException(sprintf('service "%s" tagged "%s" must have an alias attribute', $id, $tagName));
			}
		    
		    $extension->addMethodCall($methodCall, array($tag['alias'], new Reference($id)));
		}
	    ;
	}
}
