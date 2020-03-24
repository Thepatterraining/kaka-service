<?php
namespace App\Http\Adapter\ThirdPayment;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ThirdPaymentIndocAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"income_no",
         "thirdpay"=>"income_3rdpay",
         "thirdchannel"=>"income_3rdchannel",
         "account"=>"income_account",
         "provisions"=>"income_provisions",
         "cash"=>"income_cash",
         "feerate"=>"income_feerate",
         "fee"=>"income_fee",
         "type"=>"income_type",
         "checkuser"=>"income_checkuser",
         "checktime"=>"income_checktime",
         "status"=>"income_status",
         "endtime"=>"income_endtime",
         "starttime"=>"income_starttime"
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
