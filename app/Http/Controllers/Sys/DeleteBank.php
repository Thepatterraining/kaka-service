<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\BankData;
use App\Http\Adapter\Sys\BankAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteBank extends Controller
{
    //
    public function run()
    {
        $data = new BankData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
