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
class ReportRechargeDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"name"=>"report_name"
        ,"no"=>"report_no"
        ,"initCount"=>"report_initcount"
        ,"rechargeCount"=>"report_rechargecount"
        ,"resultCount"=>"report_resultcount"
        ,"initInv"=>"report_initinv"
        ,"rechargeInv"=>"report_rechargeinv"
        ,"resultInv"=>"report_resultinv"
        ,"initCash"=>"report_initcash"
        ,"rechargeCash"=>"report_rechargecash"
        ,"resultCash"=>"report_resultcash"
        ,"start"=>"report_start"
        ,"end"=>"report_end"
    ];

    protected $dicArray = [
        "runtype"=>"report_runtype"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
