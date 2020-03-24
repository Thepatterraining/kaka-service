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
class CashAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"cash"=>"sys_account_cash"
    ,"pending"=>"sys_account_pending"
    ,"change_time"=>"sys_account_change_time"
    ,"settelment_time"=>"sys_account_settelment_time"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
