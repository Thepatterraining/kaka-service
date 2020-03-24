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
class ErrorAdapter extends IAdapter
{
    protected $mapArray = [
    //	 "id"=>"id",
    "code"=>"error_code",
    "msg"=>"error_msg"//,
    //"level"=>"error_level"
       // ,"requireauth"=>"error_requireauth"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
