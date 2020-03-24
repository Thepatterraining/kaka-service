<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class GetTranactionOrderList extends QueryController
{

    public function getData()
    {
        return new  TranactionOrderData();
    }

    public function getAdapter()
    {
        return new TranactionOrderAdapter();
    }

    protected function getItem($arr)
    {
        $userAdp = new UserAdapter();
        $userData = new UserData();
        $buyer = $userData ->get($arr["buyUserid"]);
            $buyerInfo = $userAdp ->getDataContract($buyer, ["mobile","loginid","name"], true);
            $buyerInfo['regTime'] = $userData->getRegTime($buyerInfo['mobile']);
            $arr["buyUserid"]=$buyerInfo;

            $seller = $userData->get($arr["sellUserid"]);
            $sellerInfo = $userAdp ->getDataContract($seller, ["loginid","name"], true);
            $arr["sellUserid"]=$sellerInfo;
            return $arr;
    }
}
