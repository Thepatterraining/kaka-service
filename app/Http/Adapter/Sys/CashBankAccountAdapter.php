<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

class CashBankAccountAdapter extends IAdapter
{
    protected $mapArray = [
    "no"=>"account_no"
         ,"name"=>"account_name"
        , "bank"=>"account_bank"
    ,"cash"=>"account_cash"
    ,"pending"=>"account_pending"
    ,"change_time"=>"account_change_time"
    ,"settelment_time"=>"account_settelment_time"
    ,"type"=>"account_type"
    ];

    protected $dicArray = [
    "type"=>"account_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
