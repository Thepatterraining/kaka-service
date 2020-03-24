<?php
namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Data\Cash\BankAccountData;
use App\Http\Adapter\Sys\CashBankAccountAdapter ;
use App\Data\Sys\BankData;
use App\Http\Adapter\Sys\BankAdapter;
use App\Http\HttpLogic\DictionaryLogic;
use App\Http\HttpLogic\BankLogic;

class ListCashBankAccount extends Controller
{
    
    protected function run()
    {
        $datafac = new BankAccountData();
        $adapter = new CashBankAccountAdapter();
        $request['filters']['type'] = BankAccountData::TYPE_PLATFORM;
        $filters = $adapter->getFilers($request);
        $models = $datafac->query($filters, 10, 1);
        $bankfac = new BankLogic();
        $items=array();
 
        foreach ($models["items"] as $model) {
            $itemtoadd = $adapter->getDataContract($model, ["no","name","bank"], true);
            $itemtoadd["bank"]= $bankfac->getBank($itemtoadd["bank"]);
            $items[]=$itemtoadd;
        }
        $this->Success($items);
    }
}
