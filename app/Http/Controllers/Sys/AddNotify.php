<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\NotifyData;
use App\Http\Adapter\Sys\NotifyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddNotify extends Controller
{
    //
    protected function run()
    {

        $adapter = new NotifyAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new NotifyData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
