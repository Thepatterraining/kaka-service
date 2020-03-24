<?php
namespace App\Http\Adapter\Pay;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class PayJournalAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"pay3rd_journal_no"
    ,"datetime"=>"pay3rd_journal_datetime"
    ,"payid"=>"pay3rd_journal_payid"
    ,"channelid"=>"pay3rd_journal_channelid"
    ,"in"=>"pay3rd_journal_in"
    ,"out"=>"pay3rd_journal_out"
    ,"pending"=>"pay3rd_journal_pending"
    ,"type"=>"pay3rd_journal_type"
    ,"jobno"=>"pay3rd_journal_jobno"
    ,"status"=>"pay3rd_journal_status"
    ,"resultpending"=>"pay3rd_journal_resultpending"
        ,"resultcash"=>"pay3rd_jounral_resultcash"
    ,"hash"=>"hash"
    ];

    protected $dicArray = [
        "status"=>"payjournal_status",
        "type"=>"payjournal_type",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
