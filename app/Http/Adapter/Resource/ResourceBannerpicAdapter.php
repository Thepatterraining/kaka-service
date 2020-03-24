<?php
namespace App\Http\Adapter\Resource;

use App\Http\Adapter\IAdapter;

class ResourceBannerpicAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"bannerName"=>"banner_name"
        ,"resourceGroup"=>"banner_resourceid"
        ,"resourceGroupInclude"=>"banner_index"
        ,"resourceGroupLevel"=>"banner_modeldefine_id"
        ,"bannerModelDefineName"=>"banner_modeldefine_name"
        ,"bannerModelDefineTypeId"=>"banner_modeldefine_type_id"
        ,"bannerResModelDefineId"=>"banner_res_model_define_id"
        ,"bannerResModelDefineName"=>"banner_res_model_define_name"
        ,"bannerResModelDataId"=>"banner_res_model_data_id"
        ,"bannerResUrl"=>"banner_res_url"
        ,"bannerShowUrl"=>"banner_show_url"
        ,"bannerNote"=>"banner_note"
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
