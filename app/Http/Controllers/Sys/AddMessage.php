<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\MessageData;
use App\Http\Adapter\Sys\MessageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddMessage extends Controller
{
    //
    protected function run()
    {

        $adapter = new MessageAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new MessageData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
