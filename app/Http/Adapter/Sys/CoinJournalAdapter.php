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
class CoinJournalAdapter extends IAdapter
{
    protected $mapArray = [
    "no"=>"syscoin_journal_no"
    ,"datetime"=>"syscoin_journal_datetime"
    ,"in"=>"syscoin_journal_in"
    ,"out"=>"syscoin_journal_out"
    ,"pending"=>"syscoin_journal_pending"
    ,"type"=>"syscoin_journal_type"
    ,"jobNo"=>"syscoin_journal_jobno"
    ,"status"=>"syscoin_journal_status"
    ,"resultPending"=>"syscoin_result_pending"
    ,"resultCash"=>"syscoin_result_cash"
    ,"hash"=>"hash"
    ,"coinType"=>"syscoin_coin_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
