<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Trade\TranactionOrderAdapter;

class GetTranactionOrderInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:transaction_order,order_no|dic:bank",
        "bankno"=>"dic:bank"
    ];

    protected $validateMsg = [
        "no.required"=>"请输入交易单据号",
        "no.exists:transaction_order,order_no"=>"交易单据号不存在",
    ];

    //管理员查询交易详细
    /**
     * @param no 交易单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $orderNo = $request['no'];
        $data = new TranactionOrderData();
        $adapter = new TranactionOrderAdapter();
        $item = $data->getByNo($orderNo);
        $res = $adapter->getDataContract($item);
        $this->Success($res);
    }
}
