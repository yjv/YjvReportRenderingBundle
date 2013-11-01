<?php

namespace Yjv\Bundle\ReportRenderingBundle;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddDataTransformersPass;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddTypesPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class YjvReportRenderingBundle extends Bundle
{
	public function build(ContainerBuilder $container) {

		$reportRenderingReflector = new \ReflectionClass('Yjv\ReportRendering\ReportRendering');
		$container->setParameter('yjv_report_rendering_dir', dirname($reportRenderingReflector->getFileName()));
	    
	    $container->addCompilerPass(new AddTypesPass(array(
	        'yjv.report_rendering.column.type_registry_extension' => array(
                'yjv.report_rendering.column_type',
                'yjv.report_rendering.column_type_extension',
            ),
	        'yjv.report_rendering.renderer.type_registry_extension' => array(
                'yjv.report_rendering.renderer_type',
                'yjv.report_rendering.renderer_type_extension',
            ),
	        'yjv.report_rendering.report.type_registry_extension' => array(
                'yjv.report_rendering.report_type',
                'yjv.report_rendering.report_type_extension',
            ),
	        'yjv.report_rendering.datasource.type_registry_extension' => array(
                'yjv.report_rendering.datasource_type',
                'yjv.report_rendering.datasource_type_extension',
            ),
		)));
		$container->addCompilerPass(new AddDataTransformersPass());
	}

}
