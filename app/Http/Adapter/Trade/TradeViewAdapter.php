<?php
namespace App\Http\Adapter\Trade;

use App\Http\Adapter\IAdapter;

class TradeViewAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"no"
        ,"count"=>"count"
        ,"limit"=>"limit"
        ,"scale"=>"scale"
        ,"amount"=>"amount"
        ,"userid"=>"userid"
        ,"coinType"=>"cointype"
        ,"transCount"=>"transcount"
        ,"status"=>"status"
        ,"showPrice"=>"showprice"
        ,"showCount"=>"showcount"
        ,"datetime"=>"datetime"
        ,"feePrice"=>"feeprice"
        ,"feeCount"=>"feecount"
        ,"averagePrice"=>"averageprice"

    ];
    protected $dicArray =[
    
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
