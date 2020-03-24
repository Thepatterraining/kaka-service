<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectInfoItemAdapter extends IAdapter
{
    protected $mapArray = [
         "projectid"=>"project_id"
        ,"coinType"=>"project_no"
        ,"itemid"=>"proj_itemid"
        ,"value"=>"proj_itemvalue"
        ,"name"=>"proj_itemname"
        ,"itemGroupName"=>"proj_itemgroupname"
        ,"itemGroupIndex"=>"proj_itemgroupindex"
        ,"itemIndex"=>"proj_itemindex"
        ,"pre"=>"proj_itemprenote"
        ,"suf"=>"proj_itemlastnote"
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
