<?php

namespace App\Http\Controllers\User;

use App\Data\Cash\BankAccountData;
use App\Http\Adapter\Sys\CashBankAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCashBankList extends Controller
{
    /**
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new BankAccountData();
        $adapter = new CashBankAccountAdapter();
        $item = $data->find();
        $item = $adapter->getDataContract($item);
        $this->Success($item);
    }
}
