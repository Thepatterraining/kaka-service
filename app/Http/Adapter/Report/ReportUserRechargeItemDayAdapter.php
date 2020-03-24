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
class ReportUserRechargeItemDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"report_no"
        ,"rechargeChannelId"=>"report_recharge_channel_id"
        ,"type"=>"report_recharge_type"
        ,"initCount"=>"report_initcount"
        ,"rechargeCount"=>"report_rechargecount"
        ,"resultCount"=>"report_resultCount"
        ,"initInv"=>"report_initinv"
        ,"rechargeInv"=>"report_rechargeinv"
        ,"resultInv"=>"report_resultinv"
        ,"initCash"=>"report_initcash"
        ,"rechargeCash"=>"report_rechargecash"
        ,"resultCash"=>"report_resultcash"
        ,"date"=>"report_date"
    ];

    protected $dicArray = [

    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
