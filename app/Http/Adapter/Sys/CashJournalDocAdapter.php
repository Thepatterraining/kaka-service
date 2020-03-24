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
class CashJournalDocAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"syscash_journaldoc_no"
    ,"notes"=>"syscash_journaldoc_notes"
    ,"fromBankCard"=>"syscash_journaldoc_frombankcard"
    ,"toBankCard"=>"syscash_journaldoc_tobankcard"
    ,"fromBankCardType"=>"syscash_journaldoc_frombankcardtype"
    ,"toBankCardType"=>"syscash_journaldoc_tobankcardtype"
    ,"amount"=>"syscash_journaldoc_amount"
    ,"checkUser"=>"syscash_journaldoc_checkuser"
    ,"checkTime"=>"syscash_journaldoc_checktime"
    ,"success"=>"syscash_journaldoc_success"
    ,"type"=>"syscash_journaldoc_type"
    ,"status"=>"syscash_journaldoc_status"
    ];

    protected $dicArray = [
        "type"=>"syscash_journaldoc_type",
        "status"=>"syscash_journaldoc_status",
        "fromBankCardType"=>"account_type",
        "toBankCardType"=>"account_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
