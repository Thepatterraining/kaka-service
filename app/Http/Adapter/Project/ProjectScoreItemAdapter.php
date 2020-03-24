<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectScoreItemAdapter extends IAdapter
{
    protected $mapArray = [
         "projectid"=>"project_id"
        ,"coinType"=>"project_no"
        ,"scoreid"=>"scoreitem_id"
        ,"score"=>"scoreitem_value"
        ,"name"=>"scoreitem_name"
        ,"priority"=>"scoreitem_priority"
        ,"index"=>"scoreitem_index"
        ,"scale"=>"scoreitem_scale"
        ,"max"=>"scoreitem_max"
        ,"min"=>"scoreitem_min"
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
