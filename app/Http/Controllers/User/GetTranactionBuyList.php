<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionBuyData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionBuyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTranactionBuyList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer"
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数"
    ];

    //用户查询买单
    /**
     * @param pageIndex 页码
     * @param pageSize 每页数量
     * @param status 状态
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $userId = $this->session->userid;
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new TranactionBuyData();
        $adapter = new TranactionBuyAdapter();
        $request['filters']['userid'] = $userId;
        $filters = $adapter->getFilers($request);
        $item = $data->query($filters, $pageSize, $pageIndex);
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
