<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectTypeItemAdapter extends IAdapter
{
    protected $mapArray = [
         "projTypeid"=>"projtype_id"
        ,"itemid"=>"item_id"
        ,"index"=>"item_index"
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
