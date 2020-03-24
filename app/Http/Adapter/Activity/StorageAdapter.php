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
class StorageAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"activity_storage_no"
        ,"activityno"=>"activity_no"
        ,"status"=>"activity_storage_status"
        ,"userid"=>"activity_storage_userid"
    ];

    protected $dicArray = [
        "status"=>"activity_storage_status"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
