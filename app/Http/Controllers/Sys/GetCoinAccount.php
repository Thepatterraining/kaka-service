<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CoinAccountData;
use App\Http\Adapter\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCoinAccount extends Controller
{
    //
    public function run()
    {
        $adapter = new CoinAccountAdapter();
        $data = new CoinAccountData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
