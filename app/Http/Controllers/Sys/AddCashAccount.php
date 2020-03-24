<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddCashAccount extends Controller
{
    //
    protected function run()
    {

        $adapter = new CashAccountAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new CashAccountData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);
        $datafac->create($model);
        $item = $adapter->getDataContract($model);
        $this->Success($item);
    }
}
