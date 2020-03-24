<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectInvestsTypeDefineAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"name"=>"investstype_name"
        ,"note"=>"investstype_note"
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
