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
class ConfigAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"config_key"=>"config_key"
    ,"config_text"=>"config_text"
        ,"config_value"=>"config_value"
    ];

    protected $dicArray = [];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
