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
class ReportUserCoinItemDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"report_no"
        ,"coinType"=>"report_cointype"
        ,"initCount"=>"report_initcount"
        ,"initPending"=>"report_initpending"
        ,"recharge"=>"report_recharge"
        ,"withdrawal"=>"report_withdrawal"
        ,"buy"=>"report_buy"
        ,"sell"=>"report_sell"
        ,"frozen"=>"report_frozen"
        ,"count"=>"report_count"
        ,"pending"=>"report_pending"
        ,"holding"=>"report_holding"
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
