<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\CoinAccountData;
use App\Http\Adapter\Sys\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteCoinAccount extends Controller
{
    //
    public function run()
    {
        $data = new CoinAccountData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->Success($item);
    }
}
