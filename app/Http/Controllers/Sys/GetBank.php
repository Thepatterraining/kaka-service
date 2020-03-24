<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;

class GetBank extends Controller
{

    public function run()
    {
        $adapter = new BankAdapter();
        $data = new BankData();
        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
