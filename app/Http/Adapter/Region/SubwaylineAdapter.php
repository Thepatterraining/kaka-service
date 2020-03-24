<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class SubwaylineAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"subwayline_name"
        ,"cityid"=>"subwayline_cityid"
        ,"cityName"=>"subwayline_cityname"
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
