<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\NotifyData;
use App\Http\Adapter\Sys\NotifyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveNotify extends Controller
{
    //
    protected function run()
    {

        $adapter = new NotifyAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new NotifyData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
