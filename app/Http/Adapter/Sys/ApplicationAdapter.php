<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * 应用管理
 *
 * @author zhoutao
 * @date   2017.11.7
 */
class ApplicationAdapter extends IAdapter
{
    protected $mapArray = [
         "app_id"=>"app_id",
         "app_name"=>"app_name",
         "app_key"=>"app_key",
         "app_version"=>"app_version",
         "app_remark"=>"app_remark",
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
