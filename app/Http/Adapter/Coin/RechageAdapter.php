<?php
namespace App\Http\Adapter\Coin;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class RechageAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"coin_recharge_no"
        ,"cointype"=>"coin_recharge_cointype"
        ,"amount"=>"coin_recharge_amount"
        ,"userid"=>"coin_recharge_userid"
        ,"chkuserid"=>"coin_recharge_chkuserid"
        ,"time"=>"coin_recharge_time"
        ,"chktime"=>"coin_recharge_chktime"
        ,"address"=>"coin_recharge_address"
        ,"success"=>"coin_recharge_success"
        ,"type"=>"coin_recharge_type"
        ,"status"=>"coin_recharge_status"
    ];

    protected $dicArray = [
        "type"=>"coin_rechage_type",
        "status"=>"coin_rechage"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
