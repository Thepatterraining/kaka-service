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
class DictionaryAdapter extends IAdapter
{
    protected $mapArray = [
    "no"=>"dic_no"
        ,"type"=>"dic_type"
        ,"name"=>"dic_name"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
