<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Widget;

use Yjv\Bundle\ReportRenderingBundle\Widget\WidgetRenderer;


class WidgetRendererTest extends \PHPUnit_Framework_TestCase{

	protected $renderer;
	protected $templatingEngine;
	protected $widget;
	protected $template = 'template';
	
	public function setUp(){
		
		$this->templatingEngine = $this->getMock('Symfony\\Component\\Templating\\EngineInterface');
		$this->renderer = new WidgetRenderer($this->templatingEngine);
		$this->widget = $this->getMock('Yjv\\Bundle\\ReportRenderingBundle\\Widget\\WidgetInterface');
	}
	
	public function testRender() {
		
		$params = array();
		$expextedParams = array_merge($params, array('widget' => $this->widget));
		$expected = 'sdfssdfs';
		
		$this->widget
			->expects($this->once())
			->method('getTemplate')
			->will($this->returnValue($this->template))
		;
		
		$this->templatingEngine
			->expects($this->once())
			->method('render')
			->with($this->template, $expextedParams)
			->will($this->returnValue($expected))
		;
		
		$this->assertEquals($expected, $this->renderer->render($this->widget, $params));
	}
}
