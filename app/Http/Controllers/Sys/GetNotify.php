<?php

namespace App\Http\Controllers\Sys;

use App\Http\Adapter\Sys\NotifyAdapter;
use App\Data\Sys\NotifyData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetNotify extends Controller
{
    //
    public function run()
    {
        $adapter = new NotifyAdapter();
        $data = new NotifyData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
