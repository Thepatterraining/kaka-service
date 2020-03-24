<?php
namespace App\Http\Adapter\Coin;

use App\Http\Adapter\IAdapter;

/**
 * 地址认证信息表 adapter
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.7
 */
class CoinAddressInfoAdapter extends IAdapter
{
    protected $mapArray = [
         "coinAddress"=>"coin_address"
        ,"userName"=>"coin_user_name"
        ,"userIdno"=>"coin_user_idno"
        ,"mobile"=>"coin_user_mobile"
        ,"userEmail"=>"coin_user_email"
        ,"status"=>"coin_status"
    ];

    protected $dicArray = [
        "status"=>"coin_address_status"
    ];
}
