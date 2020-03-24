<?php
namespace App\Http\Adapter\Settlement;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class SysCashAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"settlement"=>"settlement_checkuser"
    ,"accountid"=>"settlement_accountid"
    ,"begin_amount"=>"settlement_begin_amount"
    ,"begin_pending"=>"settlement_begin_pending"
    ,"end_amount"=>"settlement_end_amount"
    ,"end_pending"=>"settlement_end_pending"
    ,"begin_time"=>"settlement_begin_time"
    ,"end_time"=>"settlement_end_time"
    ,"cyc"=>"settlement_cyc"
    ,"no"=>"settlement_no"
    ,"count"=>"settlement_jounalcount"
    ,"in"=>"settlement_in"
    ,"out"=>"settlement_out"
    ,"dvalue"=>"settlement_amount_dvalue"
    ,"flat"=>"settlement_amount_flat"
    ];
    protected $dicArray = [
        "cyc"=>"settlementtype"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
