<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectTypeScoreAdapter extends IAdapter
{
    protected $mapArray = [
         "scoreid"=>"score_id"
        ,"projTypeid"=>"projtype_id"
        ,"index"=>"score_index"
        ,"priority"=>"score_priority"
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
