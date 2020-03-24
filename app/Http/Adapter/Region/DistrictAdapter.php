<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class DistrictAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"district_name"
        ,"cityid"=>"district_cityid"
        ,"cityName"=>"district_cityname"
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
