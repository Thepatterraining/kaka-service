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
class DefineAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"eventName"=>"event_name"
        ,"eventKey"=>"event_key"
        ,"eventModel"=>"event_model"
        ,"eventType"=>"event_type"
        ,"eventFilter"=>"event_filter"
        ,"eventLevel"=>"event_level"
        ,"eventQueueType"=>"event_queue_type"
        ,"eventObserver"=>"event_observer"
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