<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class SubwaystationAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"subwaystation_name"
        ,"cityid"=>"subwaystation_cityid"
        ,"cityName"=>"subwaystation_cityname"
        ,"districtid"=>"subwaystation_districtid"
        ,"districtName"=>"subwaystation_districtname"
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
