<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\WithdrawalData;
use App\Http\Adapter\Coin\WithdrawalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCoinWithdrawalList extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

    /**
     * 用户查询提现代币记录
     *
     * @param   pageIndex 页码
     * @param   pageSize 数量
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new WithdrawalData();
        $adapter = new WithdrawalAdapter();
        $request['filters']['userid'] = $this->session->userid;
        $where = $adapter->getFilers($request);
        $item = $data->query($where, $request['pageSize'], $request['pageIndex']);

        $res = [];
        foreach ($item['items'] as $val) {
            $arr = $adapter->getDataContract($val);
            $res[] = $arr;
        }

        $item['items'] = $res;
        return $this->Success($item);
    }
}
