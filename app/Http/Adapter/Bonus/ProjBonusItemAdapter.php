<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjBonusItemAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"bonus_no",
        "coinType"=>"bonus_proj",
        "authdate"=>"bonus_authdate",
        "userid"=>"bonus_userid",
        "count"=>"bonus_count",
        "cash"=>"bonus_cash",
        "success"=>"bonus_success",
        "date"=>"updated_at",
        "projectName"=>"project_name",
        "time"=>"created_at",
        "cycle"=>"bonus_cycle",
    );

    protected $dicArray = [
        "cycle"=>"bonusitem_cycle",
    ];
}
