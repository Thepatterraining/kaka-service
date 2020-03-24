<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;

class MergeBank extends Controller
{
    public function run()
    {
        $request = $this->request->all();
        $bankNo = $request['bankNo']; //合并后存在的银行
        $mergeNo = $request['mergeNo']; //被合并的银行

        $data = new FinanceBankData();
        $data->mergeBank($bankNo, $mergeNo);

        return $this->Success();
    }
}
