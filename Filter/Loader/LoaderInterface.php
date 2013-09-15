<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter\Loader;

use Symfony\Component\HttpFoundation\Request;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;

use Symfony\Component\HttpFoundation\Response;

interface LoaderInterface
{
    /**
     * 
     * @param FilterCollectionInterface $filters
     * @param Request $request
     * @return Response|null
     */
    public function load(FilterCollectionInterface $filters, Request $request);
}
