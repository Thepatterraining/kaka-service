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
class InvitationCodeAdapter extends IAdapter
{
    protected $mapArray = [
        "userid"=>"invite_user"
        ,"code"=>"invite_code"
        ,"activityno"=>"invite_activity"
        ,"count"=>"invite_count"
    ,"maxCount"=>"invite_maxcount"
    ,"type"=>"invite_type"
    ];

    protected $dicArray = [];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
