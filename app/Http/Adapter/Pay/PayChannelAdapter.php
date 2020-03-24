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
class PayChannelAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"name"=>"channel_name"
    ,"payplatform"=>"channel_payplatform"
    ,"infeerate"=>"channel_infeerate"
    ,"infeetype"=>"channel_infeetype"
    ,"outfeerate"=>"channel_outfeerate"
    ,"outfeetype"=>"channel_outfeetype"
    ,"withdrawtype"=>"channel_withdrawtype"
    ,"withdrawset"=>"channel_withdrawset"
    ,"withdralbankno"=>"channel_withdralbankno"
    ,"dealclass"=>"channel_dealclass"
    ,"ammount"=>"channel_ammout"
        ,"pending"=>"channel_pending"
    ,"icon"=>"channel_icon"
    ];

    protected $dicArray = [
        "withdrawtype"=>"3rd_withdrawal",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
