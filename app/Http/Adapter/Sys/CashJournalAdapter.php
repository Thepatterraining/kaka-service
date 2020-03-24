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
class CashJournalAdapter extends IAdapter
{
    protected $mapArray = [
        "id"=>"id"
        ,"no"=>"syscash_journal_no"
        ,"datetime"=>"syscash_journal_datetime"
        ,"in"=>"syscash_journal_in"
        ,"out"=>"syscash_journal_out"
        ,"pending"=>"syscash_journal_pending"
        ,"type"=>"syscash_journal_type"
        ,"jobno"=>"syscash_journal_jobno"
        ,"status"=>"syscash_journal_status"
        ,"result_pending"=>"syscash_result_pending"
        ,"result_cash"=>"syscash_result_cash"
        ,"account_no"=>"syscash_jounal_account"
    ];

    protected $dicArray = [
        "type"=>"syscash_journal",
        "status"=>"cjournal_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
