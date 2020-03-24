<?php
namespace App\Http\Adapter\Resource;

use App\Http\Adapter\IAdapter;

class ResourceStoreAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"fileName"=>"filename"
        ,"fileType"=>"filetype"
        ,"storeId"=>"storeid"
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
