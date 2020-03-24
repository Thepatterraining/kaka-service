<?php

namespace App\Http\Controllers\Admin\Invitation;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Activity\InvitationData;
use App\Http\Adapter\Activity\ActivityRecordAdapter;
use App\Data\User\UserData;
use App\Http\Adapter\AdapterFac;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\User\CashAccountAdapter;

class InvitationList extends QueryController
{

    function getData()
    {

        return new InvitationData();


    }
    
    
    function getAdapter()
    {
        return new ActivityRecordAdapter();

    }
    protected function getItem($attr)
    {

        $userData = new UserData();
        $userArray = [
            "id",
            "name",
            "mobile"
        ];
        $result= $attr;
        $fac = new AdapterFac();

        $reg_user = $result["reguser"];
        $reg_user = $userData->get($reg_user);
        $reg_user = $fac->getDataContract($reg_user, $userArray, true);
        $result["reguser"]=$reg_user;

        $userCashData = new CashAccountData();
        $coinAccountData=new CoinAccountData();
        $userCashAdapter = new CashAccountAdapter();
        $cash = $userCashData->getUserCashInfo($reg_user['id']);
        $result['cashAccount'] = $userCashAdapter->getDataContract($cash, ['cash','pending']);

        $coinsPrice = $coinAccountData->getUserCoinsPrice($reg_user['id']);//获取代币现有价值
        $treature=round($cash['cash']+$cash['pending']+$coinsPrice, 2);//计算出账户总价值
        $result['cashAccount']['treature']=$treature;

        $inv_user = $result["invuser"];
        $inv_user = $userData -> get($inv_user);
        $inv_user = $fac->getDataContract($inv_user, $userArray, true);
        $result["invuser"]=$inv_user;
    

 
        return $result;
    }

}