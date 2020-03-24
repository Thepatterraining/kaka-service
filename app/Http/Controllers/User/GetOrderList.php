<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\VoucherInfoData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\OrderData;
use App\Http\Adapter\User\OrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetOrderList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数",
    ];

    /**
     * 查询用户代币交易记录
     *
     * @param   pageIndex
     * @param   pageSize
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.26
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new OrderData();
        $adapter = new OrderAdapter();
        $orderData = new TranactionOrderData();
        $voucherData = new VoucherInfoData();
        $request['filters']['userid'] = $userId;
        $filers = $adapter->getFilers($request);
        $item = $data->query($filers, $pageSize, $pageIndex);
        $res = [];
        if (count($item['items']) > 0) {
            foreach ($item['items'] as $val) {
                //去字典表查询类型和状态
                $arr = $adapter->getDataContract($val);
                if ($arr['discountno'] != '未使用') {
                    $arr['discountno'] = $voucherData->getInfo($arr['discountno']);
                    $arr['discountno'] = $arr['discountno']['val2'] . '理财金';
                }
                $arr['date'] = $orderData->getOrderDate($arr['orderno']);
                $res[] = $arr;
            }
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
