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
class NotifyGroupMemberAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"groupId"=>"group_id"
        ,"authUserId"=>"authuser_id"
        ,"authUserName"=>"authuser_name"
        ,"authUserEmail"=>"authuser_email"
        ,"authUserMobile"=>"authuser_mobile"
        ,"authUserOpenId"=>"authuser_openid"
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