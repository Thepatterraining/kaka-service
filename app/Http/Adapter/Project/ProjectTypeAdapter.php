<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectTypeAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"projtype_name"
        ,"noFmt"=>"projtype_nofmt"
        ,"id"=>"id"
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
