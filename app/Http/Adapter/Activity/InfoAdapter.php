<?php
namespace App\Http\Adapter\Activity;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class InfoAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"activity_no"
        ,"name"=>"activity_name"
        ,"start"=>"activity_start"
        ,"end"=>"activity_end"
        ,"limittype"=>"activity_limittype"
        ,"event"=>"activity_event"
        ,"limitcount"=>"activity_limitcount"
        ,"count"=>"activity_count"
        ,"filter"=>"activity_filter"
        ,"status"=>"activity_status"
        ,"code"=>"activity_code"
    ];

    protected $dicArray = [
        "limittype"=>"activity_limit",
        "status"=>"activity_status"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
