<?php
namespace App\Http\Adapter\Activity;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class VoucherInfoAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"vaucher_no"
        ,"name"=>"vaucher_name"
        ,"type"=>"vaucher_type"
        ,"val1"=>"voucher_val1"
        ,"val2"=>"voucher_val2"
        ,"val3"=>"voucher_val3"
        ,"val4"=>"voucher_val4"
        ,"model"=>"voucher_model"
        ,"event"=>"voucher_event"
        ,"filter"=>"voucher_filter"
        ,"timespan"=>"voucher_timespan"
        ,"count"=>"voucher_count"
        ,"usecount"=>"voucher_usecount"
        ,"timeoutcount"=>"voucher_timeoutcount"
        ,"locktime"=>"voucher_locktime"
        ,"gettingModel"=>"voucher_model_getting"
        ,"GettedModel"=>"voucher_model_getted"
        ,"useingModel"=>"voucher_model_useing"
        ,"usedModel"=>"voucher_model_used"
        ,"note"=>"voucher_note"
    ];
    protected $dicArray=[
                "type"=>"voucher_type"
        ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
