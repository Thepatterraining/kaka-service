<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserRebateRankAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id"
        ,"rankUser"=>"rank_user"
        ,"rankIndex"=>"rank_index"
        ,"rankRebate"=>"rank_rebate"
        ,"rankDate"=>"rank_date"
    );

    protected $dicArray = [
        
    ];
}
