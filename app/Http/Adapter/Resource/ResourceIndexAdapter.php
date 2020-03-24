<?php
namespace App\Http\Adapter\Resource;

use App\Http\Adapter\IAdapter;

class ResourceIndexAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"resourceId"=>"resource_id"
        ,"resourceTypeId"=>"resource_typeid"
        ,"resourceModelId"=>"resource_modelid"
        ,"resourceModelName"=>"resource_modelname"
        ,"resourceItemNo"=>"resource_itemno"
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
