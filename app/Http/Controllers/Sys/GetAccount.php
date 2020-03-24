<?php

namespace App\Http\Controllers\Sys;

use App\Http\Controllers\Controller;
use App\Http\Adapter\Sys\AccountAdapter;
use App\Data\Sys\AccountData;
use Illuminate\Http\Request;

class GetAccount extends Controller
{
    //
    public function run()
    {
        $adapter = new AccountAdapter();
        $data = new AccountData();
        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
