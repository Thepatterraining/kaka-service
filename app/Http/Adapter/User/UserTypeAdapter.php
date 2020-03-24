<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserTypeAdapter extends IAdapter
{
    protected $mapArray = array(
        "typeName"=>"user_type_name",
        "buyCashFeeType"=>"user_buy_cashfeetype",
        "buyCashFeeRate"=>"user_buy_cashfeerate",
        "buyCoinFeeType"=>"user_buy_coinfeetype",
        "buyCoinFeeRate"=>"user_buy_coinfeerate",
        "sellCashFeeType"=>"user_sell_cashfeetype",
        "sellCashFeeRate"=>"user_sell_cashfeerate",
        "sellCoinFeeType"=>"user_sell_coinfeetype",
        "sellCoinFeeRate"=>"user_sell_coinfeerate",
        "rechargeCash"=>"user_income_level",
        "consumptionCash"=>"user_cost_level",
        "nextRechargeCash"=>"user_next_income",
        "nextCostCash"=>"user_next_cost",
        "cashWithdrawlRate"=>"user_cash_withdrawalfeerate",
        "coinWithdrawlRate"=>"user_coin_withdrawalfeerate"
    );

    protected $dicArray = [
       "buyCashFeeType"=>"fee_rate_type",
       "buyCoinFeeType"=>"fee_rate_type",
       "sellCashFeeType"=>"fee_rate_type",
       "sellCoinFeeType"=>"fee_rate_type",

    ];
}
