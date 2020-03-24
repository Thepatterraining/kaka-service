<?php

namespace App\Http\Controllers\Admin;

use App\Data\User\UserData;
use App\Http\Adapter\Sys\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\User\CashAccountAdapter;

class GetUserList extends QueryController
{

    public function getData()
    {
        return new  UserData();
    }

    public function getAdapter()
    {
        return new UserAdapter();
    }

    protected function getItem($arr)
    {
        $userCashData = new CashAccountData();
        $coinAccountData=new CoinAccountData();
        $userCashAdapter = new CashAccountAdapter();
        $cash = $userCashData->getUserCashInfo($arr['id']);
            $arr['cashAccount'] = $userCashAdapter->getDataContract($cash, ['cash','pending']);

            $coinsPrice = $coinAccountData->getUserCoinsPrice($arr['id']);//获取代币现有价值
            $treature=round($cash['cash']+$cash['pending']+$coinsPrice, 2);//计算出账户总价值
            $arr['cashAccount']['treature']=$treature;
            return $arr;
    }
}
