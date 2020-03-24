<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LoginLogData;
use App\Http\Adapter\Sys\LoginLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddLoginLog extends Controller
{
    //
    protected function run()
    {

        $adapter = new LoginLogAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new LoginLogData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
