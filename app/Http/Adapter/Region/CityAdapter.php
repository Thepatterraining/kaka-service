<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class CityAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"city_name"
        ,"fullName"=>"city_fullname"
        ,"shortName"=>"city_shortname"
        ,"provinceid"=>"city_provinceid"
        ,"provinceName"=>"city_provincename"
        ,"country"=>"city_country"
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
