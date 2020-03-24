<?php

namespace App\Http\Controllers\User;

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

    //用户查询交易详细
    /**
     * @param no 交易单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $orderNo = $request['no'];
        $data = new TranactionOrderData();
        $adapter = new TranactionOrderAdapter();
        $filter['filters']['userid'] = $userId;
        $filter['filters']['no'] = $orderNo;
        $filers = $adapter->getFilers($filter);
        $item = $data->find($filers);
        $this->Success($item);
    }
}
