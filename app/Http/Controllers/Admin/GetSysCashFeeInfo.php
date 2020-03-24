<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashFeeData;
use App\Http\Adapter\Sys\CashFeeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSysCashFeeInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:sys_cash_fee,cash_withdrawal_feeno",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号",
        "no.exists:sys_cash_fee,cash_withdrawal_feeno"=>"单据号不存在",
    ];

    //查找手续费信息
    /**
     * @param no 手续费单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashFeeData();
        $adapter = new CashFeeAdapter();
        $no = $this->request->input('no');
        $item = $data->getByNo($no);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
