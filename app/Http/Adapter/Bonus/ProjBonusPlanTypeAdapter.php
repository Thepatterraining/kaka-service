<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjBonusPlanTypeAdapter extends IAdapter
{
    protected $mapArray = array(
        "name"=>"bonusplan_typename"
        ,"note"=>"bonusplan_typenote"
        ,"status"=>"bonusplan_typestatus"
        ,"exp"=>"bonusplan_exp"
    );

    protected $dicArray = [
        
    ];
}
