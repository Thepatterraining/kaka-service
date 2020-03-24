<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCashAccount extends Controller
{
    //
    public function run()
    {
        $adapter = new CashAccountAdapter();
        $data = new CashAccountData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
