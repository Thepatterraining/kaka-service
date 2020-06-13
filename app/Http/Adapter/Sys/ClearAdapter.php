<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * 清算
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ClearAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id",
        "no" => "clear_no",
         "coinType"=>"clear_coin_type",
         "amount"=>"clear_amount",
         "count"=>"clear_count",
         "price"=>"clear_price",
         "userid" => "clear_userid",
         "createTime" => "created_at",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
