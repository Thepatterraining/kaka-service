<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Data\Coin\WithdrawalData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Adapter\Coin\WithdrawalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCoinWithdrawalList extends QueryController
{


    public function getData()
    {
        return new  WithdrawalData();
    }

    public function getAdapter()
    {
        return new WithdrawalAdapter();
    }

    protected function getItem($arr)
    {
        $adminData = new UserData();
        $adminAdapter = new UserAdapter();
        if ($arr["chkuserid"]) {
                $useritem = $adminData->get($arr["chkuserid"]);
                $userarr = $adminAdapter->getDataContract($useritem, $userArray, true);
                $arr["chkuserid"] = $userarr;
        }
        return $arr;
    }
}
