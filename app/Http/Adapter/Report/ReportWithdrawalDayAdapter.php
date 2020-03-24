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
class ReportWithdrawalDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"name"=>"report_name"
        ,"no"=>"report_no"
        ,"initCount"=>"report_initcount"
        ,"withdrawalCount"=>"report_withdrawalcount"
        ,"resultCount"=>"report_resultcount"
        ,"initUncheckCount"=>"report_inituncheckcount"
        ,"withdrawalUncheckCount"=>"report_withdrawaluncheckcount"
        ,"resultUncheckCount"=>"report_resultuncheckcount"
        ,"initInv"=>"report_initinv"
        ,"withdrawalInv"=>"report_withdrawalinv"
        ,"resultInv"=>"report_resultinv"
        ,"initCash"=>"report_initcash"
        ,"withdrawalCash"=>"report_withdrawalcash"
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
