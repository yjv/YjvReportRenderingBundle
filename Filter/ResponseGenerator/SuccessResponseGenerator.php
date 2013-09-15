<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter\ResponseGenerator;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

class SuccessResponseGenerator implements ResponseGeneratorInterface
{
    public function generateResponse(Request $request)
    {
        return new Response();
    }
}
