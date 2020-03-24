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
class BankAdapter extends IAdapter
{
    protected $mapArray = [
    // "id"=>"id",
         "type"=>"bank_type",
         "name"=>"bank_name",
         "add"=>"bank_add",
         "no"=>"bank_no"
    ];

    protected $dicArray = [
        // "type"=>"bank",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
