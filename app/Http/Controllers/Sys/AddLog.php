<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LogData;
use App\Http\Adapter\Sys\LogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddLog extends Controller
{
    //
    protected function run()
    {

        $adapter = new LogAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new LogData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
