<?php
namespace App\Http\Adapter\Pay;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class PayIncomedocsAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"income_no"
    ,"pay"=>"income_3rdpay"
    ,"channel"=>"income_3rdchannel"
    ,"account"=>"income_account"
    ,"provisions"=>"income_provisions"
    ,"cash"=>"income_cash"
    ,"feerate"=>"income_feerate"
    ,"fee"=>"income_fee"
    ,"type"=>"income_type"
    ,"checkuser"=>"income_checkuser"
    ,"checktime"=>"income_checktime"
        ,"status"=>"income_status"
    ];

    protected $dicArray = [
        "type"=>"payincome_type",
        "status"=>"payincome_status",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
