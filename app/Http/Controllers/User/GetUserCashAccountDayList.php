<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashAccountData;
use App\Http\Adapter\User\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Http\Controllers\QueryController;

class GetUserCashAccountDayList extends QueryController
{

    public function getData()
    {
        return new  CashAccountData();
    }

    public function getAdapter()
    {
        return new CashAccountAdapter();
    }

    // protected function getItem($arr)
    // {
    //     $date=date_format(date_create($arr['voucherstorege_usetime']),"Y-m-d");
    //     if($date==date('Y-m-d'))
    //     {
    //         return $arr;
    //     }
    //     else
    //     {
    //         return null;
    //     }
    //     // $arr['item'] = $itemData->getInfo($arr['cointype']);
    //     //     $arr['order'] = $orderData->getInfo($arr['cointype']);

    //     //     $user = $userFac ->get($arr["userid"]);
    //     //     $arr["userid"]= $userAdaper->getDataContract($user);
    //     //     return $arr;
    // }
}
