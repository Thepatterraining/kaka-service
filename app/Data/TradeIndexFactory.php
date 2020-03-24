<?php
namespace App\Data;

use Illuminate\Support\Facades\Log;
use App\Http\Utils\RaiseEvent;
 

class TradeIndexFactory
{
    protected $facArray = [
        'week'=>"App\Data\TradeIndex\WeekTradeIndexFactory",
        'day'=>"App\Data\TradeIndex\DayTradeIndexFactory",
        'month'=>"App\Data\TradeIndex\MonthTradeIndexFactory",
        'hour'=>"App\Data\TradeIndex\HourTradeIndexFactory",
    ];

    /**
     * 增加交易
     *
     * @param  $coinType 代币类型
     * @param  $count 数量
     * @param  $price 价格
     * @date   2017.8.18
     * @author zhoutao
     */
    public function addTrade($coinType, $price)
    {
        foreach ($this->facArray as $key => $fac) {
            $data = new $fac;
            $data->addTrade($coinType, $price);
        }
    }

    /**
     * 查询
     *
     * @param  $type
     * @param  $coinType 代币类型
     * @param  $open 开始时间
     * @param  $close 结束时间
     * @date   2017.8.18
     * @author zhoutao
     * 修改了逻辑
     * @author zhoutao
     * @date   2017.8.23
     */ 
    public function queryIndex($type, $coinType, $open, $close)
    {
        if (array_key_exists($type, $this->facArray)) {
            $data = new $this->facArray[$type];
            return $data->queryIndex($coinType, $open, $close);
        }
    }
}
