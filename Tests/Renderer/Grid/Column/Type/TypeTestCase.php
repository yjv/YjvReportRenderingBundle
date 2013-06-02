<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column\Type;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeResolver;

use Yjv\Bundle\ReportRenderingBundle\Tests\Factory\TestExtension;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\PropertyPathType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\RawColumnType;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnFactory;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilder;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Type\ColumnType;

class TypeTestCase extends \PHPUnit_Framework_TestCase{

	protected $builder;
	protected $factory;
	protected $resolver;
	protected $registry;
	protected $dataTransformerRegistry;
	
	protected function setUp() {

		$this->registry = new TypeRegistry();
		$this->resolver = new TypeResolver($this->registry);
		
		foreach ($this->getExtensions() as $extension) {
		    ;
    		$this->registry->addExtension($extension);
		}
		$this->dataTransformerRegistry = new DataTransformerRegistry();
		$this->factory = new ColumnFactory($this->resolver, $this->dataTransformerRegistry);
		$this->builder = new ColumnBuilder($this->factory);
	}
	
	protected function getExtensions()
	{
	    $extension = new TestExtension();
	    $extension->addType(new ColumnType())->addType(new RawColumnType())->addType(new PropertyPathType());
	    return array($extension);
	}
}
