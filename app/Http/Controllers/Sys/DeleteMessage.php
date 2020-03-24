<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\MessageData;
use App\Http\Adapter\Sys\MessageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteMessage extends Controller
{
    //
    public function run()
    {
        $data = new MessageData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
