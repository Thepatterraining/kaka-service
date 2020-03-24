<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\BankData;
use App\Http\Adapter\Sys\BankAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveBank extends Controller
{
    //
    protected function run()
    {

        $adapter = new BankAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new BankData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
