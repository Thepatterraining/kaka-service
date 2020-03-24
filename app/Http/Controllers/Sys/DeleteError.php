<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\ErrorData;
use App\Http\Adapter\Sys\ErrorAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteError extends Controller
{
    //
    public function run()
    {
        $data = new ErrorData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
