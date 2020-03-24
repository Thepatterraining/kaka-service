<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\AccountData;
use App\Http\Adapter\Sys\AccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveAccount extends Controller
{
    //
    protected function run()
    {

        $adapter = new AccountAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new AccountData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
