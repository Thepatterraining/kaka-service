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
class NotifyDefineAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"notifyName"=>"notify_name"
        ,"notifyEvent"=>"notify_event"
        ,"notifySpecialclass"=>"notify_specialclass"
        ,"notifyType"=>"notify_type"
        ,"notifyFilter"=>"notify_filter"
        ,"notifyLevel"=>"notify_level"
        ,"notifyFmt"=>"notify_fmt"
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