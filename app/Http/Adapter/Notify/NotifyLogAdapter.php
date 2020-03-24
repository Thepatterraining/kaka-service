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
class NotifyLogAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"notifyNo"=>"notify_no"
        ,"notifyEvent"=>"notify_evt"
        ,"notifyId"=>"notify_id"
        ,"notifyName"=>"notify_name"
        ,"notifyLevel"=>"notify_level"
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