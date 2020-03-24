<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class SmsLogAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"mobile"=>"mobile"
    ,"status"=>"sms_status"
        ,"text"=>"sms_text"
        ,"type"=>"sms_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
