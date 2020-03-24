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
class CashAccountAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"cash"=>"account_cash"
    ,"pending"=>"account_pending"
    ,"change_time"=>"account_change_time"
    ,"settelment_time"=>"account_settelment_time"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
