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
class ReportUserCoinDayAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"report_no"
        ,"name"=>"report_name"
        ,"cyc"=>"report_cyc"
        ,"user"=>"report_user"
        ,"userMobile"=>"report_usermobile"
        ,"userName"=>"report_username"
        ,"invUser"=>"report_invuser"
        ,"invCode"=>"report_invcode"
        ,"start"=>"report_start"
        ,"end"=>"report_end"
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
