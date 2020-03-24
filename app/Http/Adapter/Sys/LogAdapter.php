<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class LogAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"token"=>"token"
    ,"code"=>"error_code"
    ,"url"=>"url"
    ,"logtime"=>"created_at"
    ,"dumpinfo"=>"dumpinfo"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
