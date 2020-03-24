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
class WithdrawalAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"coin_withdrawal_no"
        ,"cointype"=>"coin_withdrawal_cointype"
        ,"amount"=>"coin_withdrawal_amount"
        ,"userid"=>"coin_withdrawal_userid"
        ,"chkuserid"=>"coin_withdrawal_chkuserid"
        ,"time"=>"coin_withdrawal_time"
        ,"chktime"=>"coin_withdrawal_chktime"
        ,"toaddress"=>"coin_withdrawal_toaddress"
        ,"fromaddress"=>"coin_withdrawal_fromaddress"
        ,"success"=>"coin_withdrawal_success"
        ,"type"=>"coin_withdrawal_type"
        ,"rate"=>"coin_withdrawal_rate"
        ,"status"=>"coin_withdrawal_status"
        ,"fee"=>"coin_withdrawal_fee"
        ,"out"=>"coin_withdrawal_out"
    ];

    protected $dicArray = [
        "type"=>"coin_withdrawaal_type",
        "status"=>"coin_withdrawaal"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
