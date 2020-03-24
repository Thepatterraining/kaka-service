<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\UserData;
use App\Http\Adapter\Sys\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveUser extends Controller
{
    //
    protected function run()
    {

        $adapter = new UserAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new UserData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
