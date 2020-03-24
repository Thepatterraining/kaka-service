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
class ReportTradeDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"name"=>"report_name"
        ,"no"=>"report_no"
        ,"initCount"=>"report_initcount"
        ,"tradeCount"=>"report_tradecount"
        ,"resultCount"=>"report_resultcount"
        ,"initInv"=>"report_initinv"
        ,"tradeInv"=>"report_tradeinv"
        ,"resultInv"=>"report_resultinv"
        ,"initCash"=>"report_initcash"
        ,"tradeCash"=>"report_tradecash"
        ,"resultCash"=>"report_resultcash"
        ,"initTopCount"=>"report_initcount_top"
        ,"tradeTopCount"=>"report_tradecount_top"
        ,"resultTopCount"=>"report_resultcount_top"
        ,"initTopCash"=>"report_initcash_top"
        ,"tradeTopCash"=>"report_tradecash_top"
        ,"resultTopCash"=>"report_resultcash_top"
        ,"initSecondCount"=>"report_initcount_second"
        ,"tradeSecondCount"=>"report_tradecount_second"
        ,"resultSecondCount"=>"report_resultcount_second"
        ,"initSecondCash"=>"report_initcash_second"
        ,"tradeSecondCash"=>"report_tradecash_second"
        ,"resultSecondCash"=>"report_resultcash_second"
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
