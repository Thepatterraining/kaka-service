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
class PayBanklimitAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"typeno"=>"bank_typeno"
    ,"daytop"=>"bank_daytop"
    ,"pertop"=>"bank_pertop"
    ,"perbottom"=>"bank_perbottom"
    ,"cardtype"=>"bank_cardtype"
    ,"channelid"=>"channel_id"
    ];

    protected $dicArray = [
        "cardtype"=>"bank_cardtype",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
