<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteCashAccount extends Controller
{
    //
    public function run()
    {
        $data = new CashAccountData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
