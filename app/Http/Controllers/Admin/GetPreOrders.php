<?php

namespace App\Http\Controllers\Admin;

use App\Data\Item\InfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\Product\PreOrderData;
use App\Http\Adapter\Product\PreOrderAdapter;
use App\Data\Cash\RechargeData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Data\Trade\TranactionBuyData;
use App\Http\Adapter\Trade\TranactionBuyAdapter;

class GetPreOrders extends QueryController
{
    public function getData()
    {
        return new  PreOrderData();
    }

    public function getAdapter()
    {
        return new PreOrderAdapter();
    }

    protected function getItem($arr)
    {
        $userFac = new UserData();
        $userAdaper = new UserAdapter();
        $rechargeData = new RechargeData();
        $rechargeAdaper = new RechargeAdapter();
        $buyData = new TranactionBuyData();
        $buyAdaper = new TranactionBuyAdapter();
            $user = $userFac ->get($arr["userid"]);
            $arr["userid"]= $userAdaper->getDataContract($user);

            //查询充值单
        if (!empty($arr['rechargeNo'])) {
            $recharge = $rechargeData->getByNo($arr["rechargeNo"]);
            $arr["rechargeNo"]= $rechargeAdaper->getDataContract($recharge);
        }

            //查询买单
        if (!empty($arr['buyNo'])) {
            $buy = $buyData->getByNo($arr["buyNo"]);
            $arr["buyNo"]= $buyAdaper->getDataContract($buy);
        }
        return $arr;
    }
}
