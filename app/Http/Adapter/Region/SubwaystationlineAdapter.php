<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class SubwaystationlineAdapter extends IAdapter
{
    protected $mapArray = [
        "lineid"=>"subwayline_id"
        ,"name"=>"subwayline_name"
        ,"index"=>"subwaystation_index"
        ,"stationid"=>"subwaystation_id"
        ,"stationName"=>"subwaystation_name"
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
