<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class CashJournalAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"userid"=>"usercash_journal_userid"
        ,"result_pending"=>"usercash_result_pending"
        ,"result_cash"=>"usercash_result_cash"
    ,"no"=>"usercash_journal_no"
    ,"datetime"=>"usercash_journal_datetime"
    ,"in"=>"usercash_journal_in"
    ,"out"=>"usercash_journal_out"
        ,"pending"=>"usercash_journal_pending"
        ,"type"=>"usercash_journal_type"
        ,"jobno"=>"usercash_journal_jobno"
        ,"status"=>"usercash_journal_status"
    ,"result_pending"=>"usercash_result_pending"
    ,"result_cash"=>"usercash_result_cash"
    ,"accountid"=>"usercash_journal_userid"
    ];

    protected $dicArray = [
        "type"=>"usercash_journal",
        "status"=>"journal_type"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
