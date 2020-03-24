<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class CoinJournalAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"no"=>"usercoin_journal_no"
    ,"datetime"=>"usercoin_journal_datetime"
    ,"userid"=>"usercoin_journal_userid"
    ,"in"=>"usercoin_journal_in"
    ,"out"=>"usercoin_journal_out"
        ,"pending"=>"usercoin_journal_pending"
        ,"type"=>"usercoin_journal_type"
        ,"jobno"=>"usercoin_journal_jobno"
        ,"status"=>"usercoin_journal_status"
        ,"cointype"=>"usercoin_journal_cointype"
        ,"account"=>"usercoin_journal_account"
        ,"result_pending"=>"usercoin_result_pending"
        ,"result_cash"=>"usercoin_result_cash"
    ];

    protected $dicArray = [
        "type"=>"usercoin_journal",
        "status"=>"cjournal_type",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
