<?php
namespace App\Data\Coin;

use App\Http\Adapter\IAdapter;

/**
 * 拆借映射冻结
 *
 * @author zhoutao
 * @date   2017.11.13
 */
class LendingToFrozenAdapter extends IAdapter
{
    protected $mapArray = [
        "count"=>"lending_coin_ammount"
        ,"scale"=>"lending_coin_scale"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
