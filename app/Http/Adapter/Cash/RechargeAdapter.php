<?php
namespace App\Http\Adapter\Cash;

use App\Http\Adapter\IAdapter;

class RechargeAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"cash_recharge_no",
        "amount"=>"cash_recharge_amount",
        "sysamount"=>"cash_recharge_sysamount",
        "useramount"=>"cash_recharge_useramount",
        "status"=>"cash_recharge_status",
        "userid"=>"cash_recharge_userid",
        "chkuserid"=>"cash_recharge_chkuserid",
        "bankid"=>"cash_recharge_bankid",
        "time"=>"cash_recharge_time",
        "desbankid"=>"cash_recharge_desbankid",
        "chktime"=>"cash_recharge_chktime",
        "success"=>"cash_recharge_success",
        "type"=>"cash_recharge_type",
        "body"=>"cash_recharge_body",
    );

    protected $dicArray = [
        "status"=>"cash_rechage",
        "type"=>"cash_rechage_type",
        "body"=>"cash_rechage_body",
    ];
}
