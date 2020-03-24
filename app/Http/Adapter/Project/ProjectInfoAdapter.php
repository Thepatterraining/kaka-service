<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectInfoAdapter extends IAdapter
{
    protected $mapArray = [
         "coinType"=>"project_no"
        ,"name"=>"project_name"
        ,"score"=>"project_score"
        ,"scoreScale"=>"project_scorescale"
        ,"investsTypeid"=>"project_investstype_id"
        ,"investsTypeName"=>"project_investstype_name"
        ,"statusid"=>"project_current_status"
        ,"statusName"=>"project_current_status_name"
        ,"statusDisPlay"=>"project_current_status_display"
        ,"statusIndex"=>"project_current_status_index"
        ,"statusStart"=>"project_status_start"
        ,"statusEnd"=>"project_status_end"
        ,"scale"=>"project_scale"
        ,"coinAmmount"=>"project_coinammount"
        ,"bonusType"=>"project_bonustype"
        ,"honusPeriods"=>"project_bonusperiods"
        ,"startTime"=>"project_starttime"
        ,"holdType"=>"project_holdtype"
        ,"holderid"=>"project_holderid"
        ,"holdLast"=>"project_hold_last"
        ,'id'=>'id'
        ,"type"=>"project_type"
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
