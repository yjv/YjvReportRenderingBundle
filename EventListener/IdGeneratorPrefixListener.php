<?php
namespace Yjv\Bundle\ReportRenderingBundle\EventListener;

use Yjv\ReportRendering\IdGenerator\CallCountIdGenerator;

use Symfony\Component\HttpKernel\Event\KernelEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class IdGeneratorPrefixListener implements EventSubscriberInterface
{
    protected $idGenerator;
    
    public function __construct(CallCountIdGenerator $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }
    
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => array('onKernelRequest', 100));
    }
    
    public function onKernelRequest(KernelEvent $event)
    {
        $this->idGenerator->setPrefix($event->getRequest()->getHost() . $event->getRequest()->getPathInfo());
    }
}
