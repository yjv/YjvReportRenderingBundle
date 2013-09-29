<?php
namespace Yjv\ReportRenderingBundle\Renderer\Extension\Symfony\Type\Extension;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Yjv\ReportRendering\Factory\Type\Extension\AbstractTypeExtension;

class AddFilterRouteTypeExtension extends AbstractTypeExtension
{
    protected $urlGenerator;
    
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    
    public function getExtendedType()
    {
        return 'html';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $urlGenerator = $this->urlGenerator;
        
        $resolver
            ->setDefaults(array(
    
                'filter_route' => null,
                'filter_route_params' => array(),
                'filter_uri' => function(Options $options) use ($urlGenerator) {
                    
                    if ($options['filter_route']) {
                        
                        return $urlGenerator->generate($options['filter_route'], $options['filter_route_params']);
                    }
                    
                    return null;
                }
            ))
            ->setAllowedTypes(array(
                'filter_route' => array('string', 'null'),
                'filter_route_params' => 'array'
            ))
        ;
    }
}
