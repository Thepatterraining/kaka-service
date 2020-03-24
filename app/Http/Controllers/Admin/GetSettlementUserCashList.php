<?php

namespace App\Http\Controllers\Admin;

use App\Data\Settlement\UserCashSettlementData as DataFac;
use App\Http\Adapter\Settlement\SysCashAdapter as DataAdpter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class GetSettlementUserCashList extends QueryController
{
    public function getData()
    {
        return new  DataFac();
    }

    public function getAdapter()
    {
        return new DataAdpter();
    }

    protected function getItem($arr)
    {
        $userData = new UserData();
        $userAdp = new UserAdapter();
        $userArray = ["loginid","name","idno","mobile"];
        $useritem = $userData->get($arr["accountid"]);
        $userarr = $userAdp->getDataContract($useritem, $userArray, true);
        $arr["accountid"] = $userarr;
        return $arr;
    }
}
