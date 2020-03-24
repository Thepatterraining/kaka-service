<?php
namespace App\Http\Adapter\Report;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ReportUserCashDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"report_no"
        ,"name"=>"report_name"
        //,"cyc"=>"report_cyc"
        ,"user"=>"report_user"
        ,"userMobile"=>"report_usermobile"
        ,"userName"=>"report_username"
        ,"invUser"=>"report_invuser"
        ,"invCode"=>"report_invcode"
        ,"rechargeCash"=>"report_rechargecash"
        ,"rechargeCount"=>"report_rechargecount"
        ,"withDrawalCash"=>"report_withdrawalcash"
        ,"withDrawalCount"=>"report_withdrawalcount"
        ,"buyCount"=>"report_buycount"
        ,"buyCash"=>"report_buycash"
        ,"sellCount"=>"report_sellcount"
        ,"sellCash"=>"report_sellcash"
        ,"cashFee"=>"report_cashfee"
        ,"trade"=>"report_trade"
        ,"voucherUseCount"=>"report_voucherusecount"
        ,"voucherUseCash"=>"report_voucherusecash"
        ,"voucherCount"=>"report_vouchercount"
        ,"voucherCash"=>"report_vouchercash"
        ,"otherIncome"=>"report_otherincome"
        ,"otherOutcome"=>"report_otheroutcome"
        ,"initCash"=>"report_initcash"
        ,"initPending"=>"report_initpending"
        ,"resultCash"=>"report_resultcash"
        ,"resultPending"=>"report_resultpending"
        ,"income"=>"report_income"
        ,"outcome"=>"report_outcome"
        ,"start"=>"report_start"
        ,"end"=>"report_end"
       
    ];
    protected $dicArray = [
        "cyc"=>"report_cyc"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
