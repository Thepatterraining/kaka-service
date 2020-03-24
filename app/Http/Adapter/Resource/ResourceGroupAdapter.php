<?php
namespace App\Http\Adapter\Resource;

use App\Http\Adapter\IAdapter;

class ResourceGroupAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"resourceModelId"=>"resource_modelid"
        ,"resourceGroup"=>"resource_group"
        ,"resourceGroupInclude"=>"resource_group_include"
        ,"resourceGroupLevel"=>"resource_group_level"
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
