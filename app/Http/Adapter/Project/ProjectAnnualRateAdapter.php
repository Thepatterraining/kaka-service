<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectAnnualRateAdapter extends IAdapter
{
    protected $mapArray = [
         "projectid"=>"proj_id"
        ,"coinType"=>"project_no"
        ,"rate"=>"annualrate_value"
        ,"year"=>"annualrate_year"
        ,"isHistory"=>"annualrate_ishistory"
    ];

    protected $dicArray = [
        
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
