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
class GroupAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"group_no"
        ,"name"=>"group_name"
        ,"type"=>"group_type"
    ];

    protected $dicArray = [
        "type"=>"group_type",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
