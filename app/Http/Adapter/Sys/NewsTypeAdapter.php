<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * 公告类型的adapter
 */ 
class NewsTypeAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"newstype_name"
        ,"no"=>"newstype_no"
        ,"content"=>"newstype_content"
        ,"pubdate"=>"newstype_pubdate"
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
