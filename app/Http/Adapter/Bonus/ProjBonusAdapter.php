<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjBonusAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"bonus_no",
        "coinType"=>"bonus_proj",
        "authdate"=>"bonus_authdate",
        "plancash"=>"bonus_plancash",
        "planfee"=>"bonus_planfee",
        "dealcash"=>"bonus_dealcash",
        "dealfee"=>"bonus_dealfee",
        "cash"=>"bonus_cash",
        "unit"=>"bonus_unit",
        "holdings"=>"bonus_holdings",
        "distributeCount"=>"bonus_distributecount",
        "status"=>"bonus_status",
        "chkuserid"=>"bonus_chkuserid",
        "chkTime"=>"bonus_chktime",
        "time"=>"bonus_time",
    );

    protected $dicArray = [
        "status"=>"bonus_status",
    ];
}
