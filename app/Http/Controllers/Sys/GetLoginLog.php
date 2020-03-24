<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LoginLogData;
use App\Http\Adapter\Sys\LoginLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetLoginLog extends Controller
{
    //
    public function run()
    {
        $adapter = new LoginLogAdapter();
        $data = new LoginLogData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
