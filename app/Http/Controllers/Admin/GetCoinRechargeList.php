<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Data\Coin\RechageData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Adapter\Coin\RechageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCoinRechargeList extends QueryController
{

    public function getData()
    {
        return new  RechageData();
    }

    public function getAdapter()
    {
        return new RechageAdapter();
    }

    protected function getItem($arr)
    {
        $adminData = new UserData();
        $adminAdapter = new UserAdapter();
        $userArray = ["loginid","name","idno","mobile"];
        if ($arr["chkuserid"]) {
            $useritem = $adminData->get($arr["chkuserid"]);
            $userarr = $adminAdapter->getDataContract($useritem, $userArray, true);
            $arr["chkuserid"] = $userarr;
        }
        return $arr;
    }
}
