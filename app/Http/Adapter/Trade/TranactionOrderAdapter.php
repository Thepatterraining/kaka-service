<?php
namespace App\Http\Adapter\Trade;

use App\Http\Adapter\IAdapter;

class TranactionOrderAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"no"=>"order_no"
    ,"count"=>"order_count"
    ,"price"=>"order_price"
    ,"cashRate"=>"order_cash_rate"
    ,"coinRate"=>"order_coin_rate"
        ,"cashFee"=>"order_cash_fee"
        ,"coinFee"=>"order_coin_fee"
        ,"buyNo"=>"order_buy_no"
        ,"sellNo"=>"order_sell_no"
        ,"sellUserid"=>"order_sell_userid"
        ,"buyUserid"=>"order_buy_userid"
        ,"sellCoinaccount"=>"order_sell_coinaccount"
        ,"sellCashaccount"=>"order_sell_cashacount"
        ,"buyCoinaccount"=>"order_buy_coinaccount"
        ,"buyCashaccount"=>"order_buy_cashaccount"
        ,"cash"=>"order_cash"
        ,"coin"=>"order_coin"
        ,"amount"=>"order_amount"
        ,"type"=>"order_coin_type"
        ,"chktime"=>"created_at"
        ,"sellCashFeeType"=>"order_cash_feetype"
        ,"sellCoinFeeType"=>"order_coin_feetype"
        ,"buyCashFeeType"=>"order_buycash_feetype"
        ,"buyCoinFeeType"=>"order_buycoin_feetype"
        ,"buyCashFee"=>"order_buycash_fee"
        ,"sellCoinFeeRate"=>"order_sellcoin_feerate"
        ,"sellCoinFee"=>"order_sellcoin_fee"
        ,"scale"=>"order_scale"
        ,"touserShowPrice"=>"order_touser_showprice"
        ,"touserShowCount"=>"order_touser_showcount"
        ,"buyLevelType"=>"order_buy_leveltype"
        ,"sellLevelType"=>"order_sell_leveltype"
        ,"assetsName"=>"order_coin_type"
        ,"projectName"=>"project_name"
    ];

    protected function fromModel($contract, $model, $items)
    {

        $result = $contract;
        $result["product_price"] =  $model->order_price * $model->order_scale;
        return $result;
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
