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
class UserAdapter extends IAdapter
{
    protected $mapArray = [
        "user"=>"user_id"
    ,"nickname"=>"user_nickname"
    ,"name"=>"user_name"
    ,"idno"=>"user_idno"
    ,"headimgurl"=>"user_headimgurl"
    ,"sex"=>"user_sex"
    ,"mobile"=>"user_mobile"
    ,"pwd"=>"user_pwd"
    ,"paypwd"=>"user_paypwd"
    ,"status"=>"user_status"
    ,"lastlogin"=>"user_lastlogin"
    ,"id"=>"id"
    ];

    protected $dicArray = [
        "status"=>"user_status",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
    protected $fmtArray = [
        "idno"=>'substr_replace($item,substr(\'**********\',0,strlen($item) - 8),4,-4)',
    ];
}
