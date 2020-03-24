<?php
namespace App\Http\Adapter\Region;

use App\Http\Adapter\IAdapter;

class CountryAdapter extends IAdapter
{
    protected $mapArray = [
         "code"=>"country_code"
        ,"telcode"=>"country_telcode"
        ,"name"=>"country_name"
        ,"fullName"=>"country_fullname"
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
