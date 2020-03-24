<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LogData;
use App\Http\Adapter\Sys\LogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetLog extends Controller
{
    //
    public function run()
    {
        $adapter = new LogAdapter();
        $data = new LogData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
