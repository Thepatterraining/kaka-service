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
class JournalAdapter extends IAdapter
{
    protected $mapArray = [
   
        "no"=>"cash_journal_no"
        ,"datetime"=>"cash_journal_datetime"
        ,"in"=>"cash_journal_in"
        ,"out"=>"cash_journal_out"
        ,"pending"=>"cash_journal_pending"
        ,"type"=>"cash_journal_type"
        ,"jobno"=>"cash_journal_jobno"
        ,"status"=>"cash_journal_status"
        ,"account_id"=>"cash_account_id"
        ,"result_pending"=>"cash_result_pending"
        ,"result_cash"=>"cash_result_cash"
        ,"account_no"=>"cash_account_id"
    ];

    protected $dicArray = [
        "type"=>"cash_journal",
        "status"=>"journal_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
