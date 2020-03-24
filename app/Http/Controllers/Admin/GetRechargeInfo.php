<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\RechargeData;
use App\Http\Adapter\Cash\RechargeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetRechargeInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:cash_recharge,cash_recharge_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入充值单据号!",
        "no.exists:cash_recharge,cash_recharge_no"=>"充值单据号不存在!",
        "no.string"=>"充值单据号必须是字符串!",
    ];

    //查找充值详细信息
    /**
     * @param no 充值单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new RechargeData();
        $adapter = new RechargeAdapter();
        $no = $this->request->input('no');
        $item = $data->getByNo($no);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
