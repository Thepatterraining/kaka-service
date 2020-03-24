<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetError extends Controller
{
    //
    public function run()
    {
        $adapter = new ErrorAdapter();
        $data = new ErrorData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
