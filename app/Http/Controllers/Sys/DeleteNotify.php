<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\NotifyData;
use App\Http\Adapter\Sys\NotifyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteNotify extends Controller
{
    //
    public function run()
    {
        $data = new NotifyData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
