<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\MessageData;
use App\Http\Adapter\Sys\MessageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetMessage extends Controller
{
    //
    public function run()
    {
        $adapter = new MessageAdapter();
        $data = new MessageData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
