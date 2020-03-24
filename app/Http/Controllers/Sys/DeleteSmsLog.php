<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SmsLogData;
use App\Http\Adapter\SmsLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteSmsLog extends Controller
{
    //
    public function run()
    {
        $data = new SmsLogData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
