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
class ReportSumsDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"name"=>"report_name"
        ,"intcount"=>"report_intcount"
        ,"acscount"=>"report_acscount"
        ,"currentcount"=>"report_currentcount"
        ,"lastlogin"=>"report_lastlogin"
        ,"acslogin"=>"report_acslogin"
        ,"currentlogin"=>"report_currentlogin"
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
