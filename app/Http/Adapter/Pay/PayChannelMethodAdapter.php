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
class PayChannelMethodAdapter extends IAdapter
{
    protected $mapArray = [
        "channelid"=>"channel_id"
    ,"methodid"=>"method_id"
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
