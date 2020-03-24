<?php
namespace App\Http\Adapter\Product;

use App\Http\Adapter\IAdapter;

class TrendAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"proj_no"
        ,"id"=>"id"
        ,"price"=>"proj_price"
        ,"time"=>"proj_time"
        ,"pricetype"=>"proj_pricetype"
    ];

    protected $dicArray = [
        "pricetype"=>"proj_pricetype",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
