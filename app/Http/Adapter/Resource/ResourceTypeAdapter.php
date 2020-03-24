<?php
namespace App\Http\Adapter\Resource;

use App\Http\Adapter\IAdapter;

class ResourceTypeAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"resourceTypeName"=>"resource_type_name"
        ,"resourceFileType"=>"resource_filetype"
        ,"resourcePreLogic"=>"resource_pre_logic"
        ,"resourcePostLogic"=>"resource_post_logic"
        ,"resourceModelId"=>"resource_model_id"
        ,"resourceModelName"=>"resource_model_name"
        ,"resourcePreParam"=>"resource_pre_param"
        ,"resourcePostParam"=>"resource_post_param"
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
