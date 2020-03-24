<?php
namespace App\Http\Adapter\Coin;

use App\Http\Adapter\IAdapter;

/**
 * 代币转账记录表 adapter
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.13
 */
class CoinTransferLogAdapter extends IAdapter
{
    protected $mapArray = [
         "hash"=>"hash"
        ,"transType"=>"trans_type"
        ,"coinType"=>"coin_type"
        ,"from"=>"from"
        ,"to"=>"to"
        ,"gas"=>"gas"
        ,"block"=>"block"
        ,"confirm"=>"confirm"
        ,"status"=>"status"
    ];

    protected $dicArray = [
        "transType" => "coin_trans_type",
        "status" => "coin_trans_status",
    ];
}
