<?php
namespace App\Http\Adapter\Schedule;

use App\Http\Adapter\IAdapter;

class ScheduleDefineAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"schNo"=>"sch_no"
        ,"schName"=>"sch_name"
        ,"schNamestr"=>"sch_namestr"
        ,"schJobclass"=>"sch_jobclass"
        ,"schLastjob"=>"sch_lastjob"
    ];
    protected $dicArray = [
        "schType"=>"sch_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
