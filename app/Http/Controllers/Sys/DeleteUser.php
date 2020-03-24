<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\UserData;
use App\Http\Adapter\Sys\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteUser extends Controller
{
    //
    public function run()
    {
        $data = new UserData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
