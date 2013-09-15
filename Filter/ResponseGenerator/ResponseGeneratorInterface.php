<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter\ResponseGenerator;

use Symfony\Component\HttpFoundation\Request;

interface ResponseGeneratorInterface
{
    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function generateResponse(Request $request);
}
