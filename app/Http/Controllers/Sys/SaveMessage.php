<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\MessageData;
use App\Http\Adapter\Sys\MessageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveMessage extends Controller
{
    //
    protected function run()
    {

        $adapter = new MessageAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new MessageData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
