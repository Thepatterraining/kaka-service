<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveError extends Controller
{
    //
    protected function run()
    {

        $adapter = new ErrorAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new ErrorData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
