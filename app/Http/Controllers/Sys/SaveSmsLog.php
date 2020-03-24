<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SmsLogData;
use App\Http\Adapter\Sys\SmsLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveSmsLog extends Controller
{
    //
    protected function run()
    {

        $adapter = new SmsLogAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new SmsLogData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
