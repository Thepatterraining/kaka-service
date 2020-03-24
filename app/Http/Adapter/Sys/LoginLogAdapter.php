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
class LoginLogAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"user"=>"user_id"
    ,"ip"=>"login_ip"
        ,"type"=>"login_type"
        ,"time"=>"login_time"
        ,"add"=>"login_add"
        ,"mac"=>"login_mac"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
