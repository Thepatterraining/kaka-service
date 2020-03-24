<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectTagsAdapter extends IAdapter
{
    protected $mapArray = [
         "coinType"=>"project_no"
        ,"tagid"=>"project_tagid"
        ,"tagName"=>"project_tagname"
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
