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
class NotifyUserLogAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"notifyNo"=>"notify_no"
        ,"notifyLogno"=>"notify_logno"
        ,"notifyEvent"=>"notify_evt"
        ,"notifyUser"=>"notify_user"
        ,"notifyText"=>"notify_text"
        ,"notifyLevel"=>"notify_level"
        ,"notifyType"=>"notify_type"
        ,"notifyAddress"=>"notify_address"
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