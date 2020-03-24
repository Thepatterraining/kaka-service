<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectStatusAdapter extends IAdapter
{
    protected $mapArray = [
         "coinType"=>"project_no"
        ,"statusid"=>"project_status"
        ,"statusName"=>"status_name"
        ,"statusIndex"=>"status_index"
        ,"statusDisplay"=>"status_display"
        ,"statusStart"=>"status_start"
        ,"statusEnd"=>"status_end"
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
