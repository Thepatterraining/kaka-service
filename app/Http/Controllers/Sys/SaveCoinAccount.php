<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CoinAccountData;
use App\Http\Adapter\Sys\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveCoinAccount extends Controller
{
    //
    protected function run()
    {

        $adapter = new CoinAccountAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new CoinAccountData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
