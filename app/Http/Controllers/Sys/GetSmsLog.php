<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SmsLogData;
use App\Http\Adapter\Sys\SmsLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSmsLog extends Controller
{
    //
    public function run()
    {
        $adapter = new SmsLogAdapter();
        $data = new SmsLogData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
