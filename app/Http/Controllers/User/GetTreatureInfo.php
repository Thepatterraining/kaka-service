<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTreatureInfo extends Controller
{

    /**
     * 查询用户资产
     *
     * @param   $status 状态
     * @author  liu
     * @version 0.1
     * @date    2017.6.12
     */
    public function run()
    {
        $request = $this->request->all();
        $cashAccountData=new CashAccountData();
        $coinAccountData=new CoinAccountData();
        $cashAccountAdapter=new CashAccountAdapter();
        $coinAccountAdapter=new CoinAccountAdapter();

        $cash=$cashAccountData->getCash();//获取现金余额
        $pending=$cashAccountData->getPending();//获取现金在途金额
        $coinsPrice = $coinAccountData->getUserCoinsPrice($id = '');//获取代币现有价值
        $treature=round($cash+$pending+$coinsPrice, 2);//计算出账户总价值

        $res=array();
        $res['cash'] = round($cash, 2);
        $res['pending']=round($pending, 2);
        $res['treature']=$treature;
        
        return $this->Success($res);
    }
}
