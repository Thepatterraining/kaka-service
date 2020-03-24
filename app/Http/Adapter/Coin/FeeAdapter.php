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
class FeeAdapter extends IAdapter
{
    protected $mapArray = [
         "feeno"=>"coin_withdrawal_feeno"
        ,"no"=>"coin_withdrawal_no"
        ,"cointype"=>"coin_withdrawal_cointype"
        ,"feeamount"=>"coin_withdrawal_feeamount"
        ,"datetime"=>"coin_withdrawal_feetime"
        ,"chktime"=>"coin_withdrawal_feechktime"
        ,"feesuccess"=>"coin_withdrawal_feesuccess"
        ,"rate"=>"coin_withdrawal_rate"
        ,"type"=>"coin_withdrawal_feetype"
        ,"status"=>"coin_withdrawal_feestatus"
    ];

    protected $dicArray = [
        "type"=>"coin_withdrawal_feetype",
        "status"=>"coin_withdrawal_fee"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
