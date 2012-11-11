<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\ReportData;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImmutableReportDataTest extends WebTestCase{

	protected $data;
	protected $unfilteredCount;
	protected $dataClass = 'Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\ImmutableReportData';
	protected $reportData;
	
	public function setUp() {
		
		$this->data = array('thing1' => 'thing2');
		$this->unfilteredCount = 15;
		$class = $this->dataClass;
		$this->reportData = new $class($this->data, $this->unfilteredCount);
	}
	
	public function testConstructor() {
		
		try {
			
			$class = $this->dataClass;
			new $class('sdfdsf', $this->unfilteredCount);
			$this->fail('failed to throw exception on bad data param');
		} catch (\InvalidArgumentException $e) {
		}
	}
	
	public function testGettersSetters() {
		
		$this->assertEquals($this->data, $this->reportData->getData());
		$this->assertEquals($this->unfilteredCount, $this->reportData->getUnfilteredCount());
		$this->assertEquals(count($this->data), $this->reportData->getCount());
	}
}