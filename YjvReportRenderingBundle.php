<?php

namespace Yjv\Bundle\ReportRenderingBundle;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddDataTransformersPass;

use Yjv\Bundle\ReportRenderingBundle\DependencyInjection\Compiler\AddTypesPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class YjvReportRenderingBundle extends Bundle
{
	public function build(ContainerBuilder $container) {

		$container->addCompilerPass(new AddTypesPass(array(
	        'yjv.report_rendering.column_type_registry_extension' => array(
                'yjv.report_rendering.column_type',
                'yjv.report_rendering.column_type_extension',
            ),
	        'yjv.report_rendering.renderer_type_registry_extension' => array(
                'yjv.report_rendering.renderer_type',
                'yjv.report_rendering.renderer_type_extension',
            ),
	        'yjv.report_rendering.report_type_registry_extension' => array(
                'yjv.report_rendering.report_type',
                'yjv.report_rendering.report_type_extension',
            ),
        )));
		$container->addCompilerPass(new AddDataTransformersPass());
	}

}
