<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveCashAccount extends Controller
{
    //
    protected function run()
    {

        $adapter = new CashAccountAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new CashAccountData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
