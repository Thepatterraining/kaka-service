<?php
namespace App\Http\Adapter\Trade;

use App\Http\Adapter\IAdapter;

class TranactionBuyAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"no"=>"buy_no"
    ,"count"=>"buy_count"
    ,"limit"=>"buy_limit"
    ,"feerate"=>"buy_feerate"
    ,"ammount"=>"buy_ammount"
        ,"userid"=>"buy_userid"
        ,"usercointaccount"=>"buy_usercointaccount"
        ,"transcount"=>"buy_transcount"
        ,"transammount"=>"buy_transammount"
        ,"status"=>"buy_status"
        ,"lasttranstime"=>"buy_lasttranstime"
        ,"region"=>"buy_region"
    ];
    protected $dicArray =[
    "status"=>"trans_buy"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
