<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddError extends Controller
{
    //
    protected function run()
    {

        $adapter = new ErrorAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new ErrorData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
