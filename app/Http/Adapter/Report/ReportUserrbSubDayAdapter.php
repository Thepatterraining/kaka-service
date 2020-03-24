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
class ReportUserrbSubDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"report_no"
        ,"name"=>"report_name"
        //,"cyc"=>"report_cyc"
        ,"user"=>"report_user"
        ,"initInv"=>"report_initinv"
        ,"ascInv"=>"report_ascinv"
        ,"currentInv"=>"report_currentinv"
        ,"rbInitInv"=>"report_rbinitinv"
        ,"rbAscInv"=>"report_rbascinv"
        ,"rbCurrentInv"=>"report_rbcurrentinv"
        ,"initRecharge"=>"report_initrecharge"
        ,"ascRecharge"=>"report_ascrecharge"
        ,"resultRecharge"=>"report_resultrecharge"
        ,"ascRecharge"=>"report_ascrecharge"
        ,"initBuy"=>"report_initbuy"
        ,"ascBuy"=>"report_ascbuy"
        ,"resultBuy"=>"report_resultbuy"
        ,"rbRechargeInit"=>"report_rbrecharge_init"
        ,"rbRechargeAsc"=>"report_rbrecharge_asc"
        ,"rbRechargeResult"=>"report_rbrecharge_result"
        ,"rbRechargeIspay"=>"report_rbrecharge_ispay"
        ,"rbRechargePayuser"=>"report_rbrecharge_payuser"
        ,"rbRechargePaytime"=>"report_rbrecharge_paytime"
        ,"rbRechargeChkuser"=>"report_rbrecharge_chkuser"
        ,"rbRechargeChktime"=>"report_rbrecharge_chktime"
        ,"rbBuyInit"=>"report_rbbuy_init"
        ,"rbBuyAsc"=>"report_rbbuy_asc"
        ,"rbBuyResult"=>"report_rbbuy_result"
        ,"rbBuyTotalResult"=>"report_rbbuy_totalresult"
        ,"rbBuyIspay"=>"report_rbbuy_ispay"
        ,"rbBuyPayuser"=>"report_rbbuy_payuser"
        ,"rbBuyPaytime"=>"report_rbbuy_paytime"
        ,"rbBuyChkuser"=>"report_rbbuy_chkuser"
        ,"rbBuyChktime"=>"report_rbbuy_chktime"
        ,"start"=>"report_start"
        ,"end"=>"report_end"
        ,"rbRechargeStart"=>"report_rbrecharge_start"
        ,"rbBuyStart"=>"report_rbbuy_start"
        ,"enableOperation"=>"report_enable_operation"
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
