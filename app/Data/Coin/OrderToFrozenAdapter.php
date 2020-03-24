<?php
namespace App\Data\Coin;

use App\Http\Adapter\IAdapter;

/**
 * 成交映射冻结
 *
 * @author zhoutao
 * @date   2017.11.13
 */
class OrderToFrozenAdapter extends IAdapter
{
    protected $mapArray = [
        "count"=>"order_count"
        ,"scale"=>"order_scale"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
