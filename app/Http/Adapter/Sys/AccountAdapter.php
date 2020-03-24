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
class AccountAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id",
         "type"=>"sys_3rd_type",
         "name"=>"sys_3rd_name",
         "account"=>"sys_3rd_account",
         "key"=>"sys_3rd_key",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
