<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class ProvinceAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"province_name"
        ,"country"=>"province_country"
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
