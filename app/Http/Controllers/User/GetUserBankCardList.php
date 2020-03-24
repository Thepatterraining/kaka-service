<?php

namespace App\Http\Controllers\User;

use App\Data\User\BankAccountData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;

class GetUserBankCardList extends Controller
{
    protected function run()
    {
        $datafac = new BankAccountData();
        $items = $datafac->getUserBankCards();
        $adapter = new UserBankCardAdapter();
    
        $bankadapter = new BankAdapter();
        $bankdata = new BankData();
        $result = [];
        foreach ($items as $item) {
            $item2Add = $adapter->getFromModel($item, true);
            $bankModel = $bankdata->get($item2Add["bank"]);
            if ($bankModel!= null) {
                     $bankContract = $bankadapter->getFromModel($bankModel);
                   $item2Add ["bank"]=  $bankContract;
                   $result[]=$item2Add;
            }
        }
        $this->Success($result);
    }
}
