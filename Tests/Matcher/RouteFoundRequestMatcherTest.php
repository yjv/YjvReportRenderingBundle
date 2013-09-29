<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Matcher;

use Symfony\Component\HttpFoundation\Request;

use Yjv\Bundle\ReportRenderingBundle\Matcher\RouteFoundRequestMatcher;

class RouteFoundRequestMatcherTest extends \PHPUnit_Framework_TestCase
{
    protected $matcher;
    
    public function setUp()
    {
        $this->matcher = new RouteFoundRequestMatcher();
    }
    
    public function testMatches()
    {
        $request = new Request();
        $this->assertFalse($this->matcher->matches($request));
        $request->attributes->set('_route', 'fsfs');
        $this->assertTrue($this->matcher->matches($request));
    }
}
