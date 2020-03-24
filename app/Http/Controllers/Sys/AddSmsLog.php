<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SmsLogData;
use App\Http\Adapter\Sys\SmsLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddSmsLog extends Controller
{
    //
    protected function run()
    {

        $adapter = new SmsLogAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new SmsLogData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
