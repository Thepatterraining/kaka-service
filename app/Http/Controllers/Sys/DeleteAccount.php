<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\AccountData;
use App\Http\Adapter\Sys\AccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteAccount extends Controller
{
    //
    public function run()
    {
        $data = new AccountData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
