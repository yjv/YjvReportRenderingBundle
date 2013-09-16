<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter\Loader;

use Yjv\ReportRendering\Filter\MultiReportFilterCollectionInterface;

use Yjv\ReportRendering\FilterConstants;

use Symfony\Component\HttpFoundation\Request;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;

class ParameterBagLoader implements LoaderInterface
{
    protected $attributeName;
    protected $path;
    
    public function __construct($attributeName = 'request', $path = 'report_filters')
    {
        $this->attributeName = $attributeName;
        $this->path = $path;
    }
    
    public function load(FilterCollectionInterface $filters, Request $request)
    {
        $filterData = $request->{$this->attributeName}->get($this->path, array());
        $filterData = $this->normalizeFilterData($filterData, $filters);

        foreach ($filterData as $reportId => $filterValues) {
            
            if ($filters instanceof MultiReportFilterCollectionInterface) {
                
                $filters->setReportId($reportId);
            }
            
            $filters->setAll($filterValues);
        }
    }
    
    protected function normalizeFilterData(array $filterData, FilterCollectionInterface $filters)
    {
        if (!$filters instanceof MultiReportFilterCollectionInterface) {
            
            $filterData = array('report_id' => $filterData);
        }

        return array_map(function($data) 
        {
            foreach ($data as $key => $value) {
                
                if ($key == FilterConstants::LIMIT || $key == FilterConstants::OFFSET) {
                    
                    $data[$key] = (int)$value;
                }
                
                if ($key == FilterConstants::SORT) {
                    
                    $data[$key] = (array)$value;
                }
            }
            
            return $data;
        }, $filterData);
    }
}
