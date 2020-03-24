<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectInfoItemGroupAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"group_name"
        ,"index"=>"group_index"
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
