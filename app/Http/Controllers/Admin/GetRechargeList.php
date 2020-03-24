<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\RechargeData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Http\HttpLogic\DictionaryLogic;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Auth\UserData as AdminData;
use App\Http\Adapter\Auth\UserAdapter as AdminAdapter;
use App\Http\HttpLogic\BankLogic;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Data\User\BankAccountData;


class GetRechargeList extends QueryController
{

    public function getData()
    {
        return new  RechargeData();
    }

    public function getAdapter()
    {
        return new RechargeAdapter();
    }

    public function getItem($arr)
    {
        $bklogic = new BankLogic();
        $userData = new UserData();
        $userAdp = new UserAdapter();
        $adminData = new AdminData();
        $adminAdapter = new AdminAdapter();
        $userArray = ["loginid","name","idno","mobile"];
        $useritem = $userData->get($arr["userid"]);
            
            $userarr = $userAdp->getDataContract($useritem, $userArray, true);
            $arr["userid"] = $userarr;
        if ($arr["chkuserid"]) {
                $useritem = $adminData->get($arr["chkuserid"]);
                $userarr = $adminAdapter->getDataContract($useritem, $userArray, true);
                $arr["chkuserid"] = $userarr;
        }

                    $arr["card"]=$bklogic->getUserCardInfo($arr["bankid"]);

            $arr["bankid"] = $bklogic->getUserBankCardInfo($arr["bankid"]);
        return $arr;
    }
}
