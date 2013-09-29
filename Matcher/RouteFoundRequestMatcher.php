<?php
namespace Yjv\Bundle\ReportRenderingBundle\Matcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class RouteFoundRequestMatcher implements RequestMatcherInterface
{
    /**
     * @param Request $request
     * @return bool
     */
    public function matches(Request $request)
    {
        $route = $request->attributes->get('_route', false);
        return !empty($route);
    }
}
