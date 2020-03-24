<?php
namespace App\Http\Adapter\Notify;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class EventLogAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"eventNo"=>"event_no"
        ,"eventId"=>"event_id"
        ,"eventModel"=>"event_model"
        ,"eventName"=>"event_name"
        ,"eventData"=>"event_data"
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