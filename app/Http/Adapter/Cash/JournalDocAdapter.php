<?php
namespace App\Http\Adapter\Cash;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class JournalDocAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"cash_journaldoc_no"
    ,"notes"=>"cash_journaldoc_notes"
    ,"bankCard"=>"cash_journaldoc_bankcard"
    ,"bankCardType"=>"cash_journaldoc_bankcardtype"
    ,"amount"=>"cash_journaldoc_amount"
    ,"checkUser"=>"cash_journaldoc_checkuser"
    ,"checkTime"=>"cash_journaldoc_checktime"
    ,"success"=>"cash_journaldoc_success"
    ,"type"=>"cash_journaldoc_type"
    ,"status"=>"cash_journaldoc_status"
    ];

    protected $dicArray = [
        "type"=>"cash_journaldoc_type",
        "status"=>"cash_journaldoc_status",
        "bankCardType"=>"account_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
