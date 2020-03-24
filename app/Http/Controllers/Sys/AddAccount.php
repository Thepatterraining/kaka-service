<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\AccountData;
use App\Http\Adapter\Sys\AccountAdapter;

class AddAccount extends Controller
{
    //
    protected function run()
    {

        $adapter = new AccountAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new AccountData();
        $model = $datafac->newitem();
        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
