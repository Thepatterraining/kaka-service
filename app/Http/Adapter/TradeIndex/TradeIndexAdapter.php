<?php
namespace App\Http\Adapter\TradeIndex;

use App\Http\Adapter\IAdapter;

class TradeIndexAdapter extends IAdapter
{
    protected $mapArray = [
        "coinType"=>"coin_type"
        ,"priceOpen"=>"price_open"
        ,"priceClose"=>"price_close"
        ,"priceHigh"=>"price_high"
        ,"priceLow"=>"price_low"
        ,"volume"=>"volume_val"
        ,"turnover"=>"turnover_val"
        ,"timeOpen"=>"time_open"
        ,"timeClose"=>"time_close"
    ];
    protected $dicArray =[

    ];
}
