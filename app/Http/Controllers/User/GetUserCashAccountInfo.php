<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashAccountData;
use App\Http\Adapter\User\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Data\Cash\WithdrawalData;

class GetUserCashAccountInfo extends Controller
{
    //查找用户现金信息
    /**
     * @author zhouta
     * @version 0.1
     */
    public function run()
    {
        $data = new CashAccountData();
        $adapter = new CashAccountAdapter();
        $coinData = new CoinAccountData();
        $item = $data->getUserCashInfo();
        $res = $adapter->getDataContract($item);

        //获取代币价值
        $orderData = new TranactionOrderData();
        $orderCash = $orderData->getOrderTotalSum();

        // $res['cash'] = sprintf("%.2f",$res['cash']);
        // $res['pending'] = sprintf("%.2f",$res['pending']);
        $assets = $coinData->getAssets();
        $userCoinAssets = 0;
        foreach ($assets as $asset) {
            $userCoinAssets += array_get($asset, 'valuation');
        }
        //查询提现金额
        $withData = new WithdrawalData();
        $withCash = $withData->getUserWithCashs($this->session->userid, WithdrawalData::APPLY_STATUS);
        $res['totalAssets'] = $res['cash'] + $withCash + $userCoinAssets;
        $res['pending'] = $withCash;
        return $this->Success($res);
    }
}
