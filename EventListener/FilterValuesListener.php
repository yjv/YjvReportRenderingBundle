<?php
namespace Yjv\Bundle\ReportRenderingBundle\EventListener;

use Yjv\Bundle\ReportRenderingBundle\Filter\ResponseGenerator\ResponseGeneratorInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\RequestMatcherInterface;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\Filter\Loader\LoaderInterface;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FilterValuesListener implements EventSubscriberInterface
{
    const REQUEST_ATTRIBUTE_NAME = '_report_filters_match';
    protected $loader;
    protected $filters;
    protected $requestMatcher;
    protected $responseGenerator;
    
    public function __construct(
        FilterCollectionInterface $filters, 
        RequestMatcherInterface $requestMatcher,
        LoaderInterface $loader
    ) {
        $this->loader = $loader;
        $this->filters = $filters;
        $this->requestMatcher = $requestMatcher;
    }
    
    public function setResponseGenerator(ResponseGeneratorInterface $responseGenerator)
    {
        $this->responseGenerator = $responseGenerator;
        return $this;
    }
    
    public function getResponseGenerator()
    {
        return $this->responseGenerator;
    }
    
    /**
     * 
     */
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => 'onKernelRequest');
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($this->requestMatcher->matches($request)) {

            $this->loader->load($this->filters, $request);

            if ($this->responseGenerator) {
                
                $request->attributes->set('_controller', array($this, 'getResponse'));
            }
        }
    }
    
    public function getResponse(Request $request)
    {
        return $this->responseGenerator->generateResponse($request);
    }
}
