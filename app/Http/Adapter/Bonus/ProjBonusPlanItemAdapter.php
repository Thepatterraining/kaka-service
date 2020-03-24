<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjBonusPlanItemAdapter extends IAdapter
{
    protected $mapArray = array(
        "planNo"=>"bonusplan_no",
        "index"=>"bonusplan_index",
        "status"=>"bonusplan_status",
        "bonusNo"=>"bonus_no",
    );

    protected $dicArray = [
        
    ];
}
