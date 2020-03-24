<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjBonusPlanAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"bonusplan_no",
        "coinType"=>"bonusplan_coin",
        "fee"=>"bonusplan_fee",
        "cash"=>"bonusplan_cash",
        "dealFee"=>"bonusplan_dealfee",
        "dealCash"=>"bonusplan_dealcash",
        "unit"=>"bonusplan_unit",
        "status"=>"bonusplan_status",
        "checkUserid"=>"bonusplan_checkuserid",
        "checkTime"=>"bonusplan_checktime",
        "authCheck"=>"bonusplan_autocheck",
        "typeid"=>"bonusplan_typeid",
        "startTime"=>"bonusplan_starttime",
        "endTime"=>"bonusplan_endtime",
        "counts"=>"bonsuplan_counts",
    );

    protected $dicArray = [
        
    ];
}
