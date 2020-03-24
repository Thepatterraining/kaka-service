<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Data\Auth\UserData as AdminData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\Auth\UserAdapter as AdminAdapter;
use App\Http\HttpLogic\BankLogic;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserBankCardAdapter;

class GetWithdrawalList extends QueryController
{

    public function getData()
    {
        return new  WithdrawalData();
    }

    public function getAdapter()
    {
        return new WithdrawalAdapter();
    }

    public function getItem($arr)
    {
        $bklogic = new BankLogic();
        $userData = new UserData();
        $userAdp = new UserAdapter();
        $adminData = new AdminData();
        $adminAdapter = new AdminAdapter();
         $datafac = new BankAccountData();
        $bankAdapter = new UserBankCardAdapter();
        $userArray = ["loginid","name","idno","mobile"];
        $useritem = $userData->get($arr["userid"]);
            $userarr = $userAdp->getDataContract($useritem, $userArray, true);
            $arr["userid"] = $userarr;
        if ($arr["chkuserid"]) {
                $useritem = $adminData->get($arr["chkuserid"]);
                $userarr = $adminAdapter->getDataContract($useritem, $userArray, true);
                $arr["chkuserid"] = $userarr;
        }

            // $arr["bankid"]=$bklogic->getUserBankCardInfo($arr["bankid"]);
                $arr["card"]=$bklogic->getUserCardInfo($arr["bankid"]);
        if (!empty($arr['bankid'])) {
            $arr['bankid'] = $datafac->getUserBankInfo($arr['bankid']);
            $arr['bankno'] = $bankAdapter->getDataContract($arr['bankid'], ['no','name','bank']);
            $arr['bankinfo'] = $bklogic->getBankInfo($arr['bankno']['bank']);
        }
        return $arr;
    }
}
