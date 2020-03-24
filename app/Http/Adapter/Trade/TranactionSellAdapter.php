<?php
namespace App\Http\Adapter\Trade;

use App\Http\Adapter\IAdapter;

class TranactionSellAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"sell_no"
    ,"count"=>"sell_count"
    ,"limit"=>"sell_limit"
    ,"feerate"=>"sell_feerate"
    ,"ammount"=>"sell_ammount"
    ,"userid"=>"sell_userid"
    ,"usercointaccount"=>"sell_usercointaccount"
    ,"transcount"=>"sell_transcount"
    ,"transammount"=>"sell_transammount"
    ,"status"=>"sell_status"
    ,"lasttranstime"=>"sell_lasttranstime"
    ,"leveltype"=>"sell_leveltype"
    ,"region"=>"sell_region"
    ,"cointype"=>"sell_cointype"
    ,"selltime"=>"created_at"
    ,"scale"=>"sell_scale"
    ,"touserShowprice"=>"sell_touser_showprice"
    ,"touserShowcount"=>"sell_touser_showcount"
    ,"touserFeePrice"=>"sell_touser_feeprice"
    ,"touserFeeCount"=>"sell_touser_feecount"
    ];
    protected $dicArray =[
    "status"=>"trans_sell",
        "leveltype"=>"sell_level"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
