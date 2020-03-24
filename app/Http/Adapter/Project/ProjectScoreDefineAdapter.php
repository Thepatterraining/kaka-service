<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectScoreDefineAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"score_name"
        ,"scale"=>"score_scale"
        ,"min"=>"score_min"
        ,"max"=>"score_max"
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
