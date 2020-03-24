<?php
namespace App\Http\Adapter\Cash;

use App\Http\Adapter\IAdapter;

class WithdrawalAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"cash_withdrawal_no",
        "amount"=>"cash_withdrawal_amount",
        "status"=>"cash_withdrawal_status",
        "userid"=>"cash_withdrawal_userid",
        "chkuserid"=>"cash_withdrawal_chkuserid",
        "bankid"=>"cash_withdrawal_bankid",
        "time"=>"cash_withdrawal_time",
        "srcbankid"=>"cash_withdrawal_srcbankid",
        "chktime"=>"cash_withdrawal_chktime",
        "success"=>"cash_withdrawal_success",
        "type"=>"cash_withdrawal_type",
        "rate"=>"cash_withdrawal_rate",
        "fee"=>"cash_withdrawal_fee",
        "out"=>"cash_withdrawal_out",
        "body"=>"cash_withdrawal_body",
    );

    protected $dicArray = [
        "status"=>"cash_withdrawaal",
        "type"=>"cash_withdrawal_type",
        "body"=>"cash_withdrawal_body"
    ];
}
