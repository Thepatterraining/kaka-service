<?php

namespace App\Http\Controllers\User;

use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTranactionOrderList extends Controller
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

    //用户查询交易
    /**
     * @param pageIndex 页码
     * @param pageSize 每页数量
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new TranactionOrderData();
        $adapter = new TranactionOrderAdapter();
        $request['filters']['userid'] = $userId;
        $filers = $adapter->getFilers($request);
        $item = $data->query($filers, $pageSize, $pageIndex);
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            $res[] = $arr;
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
