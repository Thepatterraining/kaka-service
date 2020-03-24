<?php
namespace App\Http\Adapter\App;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class UserInfoAdapter extends IAdapter
{
    protected $mapArray = [
        "kkuserid"=>"kkuserid"
        ,"appid"=>"appid"
        ,"openid"=>"openid"
        ,"unionid"=>"unionid"
        ,"groupid"=>"groupid"
        ,"iswatch"=>"iswatch"
        ,"nickname"=>"nickname"
        ,"sex"=>"sex"
        ,"language"=>"language"
        ,"city"=>"city"
        ,"province"=>"province"
        ,"country"=>"country"
        ,"headimgurl"=>"headimgurl"
        ,"privilege"=>"privilege"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
