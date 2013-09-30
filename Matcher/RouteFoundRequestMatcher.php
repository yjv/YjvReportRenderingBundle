<?php
namespace Yjv\Bundle\ReportRenderingBundle\Matcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class RouteFoundRequestMatcher implements RequestMatcherInterface
{
    protected $routeName;
    
    public function __construct($routeName)
    {
        $this->routeName = $routeName;
    }
    
    /**
     * @param Request $request
     * @return bool
     */
    public function matches(Request $request)
    {
        return $this->routeName == $request->attributes->get('_route', false);
    }
}
