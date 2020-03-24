<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserVpAdapter extends IAdapter
{
    protected $mapArray = array(
        "userid"=>"user_id",
        "coinType"=>"coin_type",
        "enable"=>"enable",
        "enableBuyBack"=>"enable_buyback",
        "enableProduct"=>"enable_product",
    );

    protected $dicArray = [
        
    ];
}
