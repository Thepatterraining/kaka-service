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
class CashFeeAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"feeno"=>"cash_withdrawal_feeno"
    ,"feeamount"=>"cash_withdrawal_feeamount"
    ,"feestatus"=>"cash_withdrawal_feestatus"
    ,"no"=>"cash_withdrawal_no"
        ,"feetime"=>"cash_withdrawal_feetime"
        ,"feechktime"=>"cash_withdrawal_feechktime"
        ,"feesuccess"=>"cash_withdrawal_feesuccess"
        ,"feetype"=>"cash_withdrawal_feetype"
        ,"rate"=>"cash_withdrawal_rate"
    ];

    protected $dicArray = [
        "feestatus"=>"cash_withdrawal_fee",
        "feetype"=>"cash_withdrawal_feetype"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
