<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\UserData;
use App\Http\Adapter\Sys\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetUser extends Controller
{
    //
    public function run()
    {
        $adapter = new UserAdapter();
        $data = new UserData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
