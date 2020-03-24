<?php
namespace App\Http\Adapter\Coin;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ItemAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"coin_journal_no"
        ,"cointype"=>"coin_journal_cointtype"
        ,"datetime"=>"coin_journal_datetime"
        ,"in"=>"coin_journal_in"
        ,"out"=>"coin_journal_out"
        ,"pending"=>"coin_journal_pending"
        ,"type"=>"coin_journal_type"
        ,"jobno"=>"coin_journal_jobno"
        ,"status"=>"coin_journal_status"
        ,"account_id"=>"coin_account_id"
        ,"result_pending"=>"coin_result_pending"
        ,"result_cash"=>"coin_result_cash"
    ];

    protected $dicArray = [
        "type"=>"coin_journal",
        "status"=>"journal_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
