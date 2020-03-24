<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\LogData;
use App\Http\Adapter\Sys\LogAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteLog extends Controller
{
    //
    public function run()
    {
        $data = new LogData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
