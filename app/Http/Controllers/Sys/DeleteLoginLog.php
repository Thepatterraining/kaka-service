<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LoginLogData;
use App\Http\Adapter\Sys\LoginLogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteLoginLog extends Controller
{
    //
    public function run()
    {
        $data = new LoginLogData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
