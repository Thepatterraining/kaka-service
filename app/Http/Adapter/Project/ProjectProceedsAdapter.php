<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectProceedsAdapter extends IAdapter
{
    protected $mapArray = [
         "coinType"=>"project_no"
        ,"id"=>"project_proceeds_id"
        ,"name"=>"project_proceeds_name"
        ,"note"=>"project_proceeds_note"
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
