<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LoginLogData;
use App\Http\Adapter\Sys\LoginLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveLoginLog extends Controller
{
    //
    protected function run()
    {

        $adapter = new LoginLogAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new LoginLogData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
