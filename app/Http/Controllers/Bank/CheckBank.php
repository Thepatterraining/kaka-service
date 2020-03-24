<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;

class CheckBank extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:bank,0",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入银行号!",
    ];

    /**
     * 管理员审核银行
     *
     * @param   $no 银行号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.4
     */
    public function run()
    {
        $request = $this->request->all();
        $bankNo = $request['no'];
        $data = new FinanceBankData();
        $checkRes = $data->checkBank($bankNo);

        return $this->Success();
    }
}
