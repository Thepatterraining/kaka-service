<?php
namespace App\Http\Adapter\Schedule;

use App\Http\Adapter\IAdapter;

class ScheduleItemAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"schItemNo"=>"sch_itemno"
        ,"schDefNo"=>"sch_defno"
        ,"schItemName"=>"sch_itemname"
        ,"schJobNo"=>"sch_jobno"
        ,"schStatus"=>"sch_status"
    ];
    protected $dicArray = [
        "schStatus"=>"schedule_status"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
