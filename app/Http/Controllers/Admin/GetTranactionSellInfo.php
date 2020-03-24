<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTranactionSellInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:transaction_sell,sell_no",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号",
        "no.exists:transaction_sell,sell_no"=>"单据号不存在",
    ];

    //管理员查询卖单信息
    /**
     * @param no 卖单单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $sellNo = $request['no'];
        $data = new TranactionSellData();
        $adapter = new TranactionSellAdapter();
        $item = $data->getByNo($sellNo);
        $res = $adapter->getDataContract($item);
        $this->Success($res);
    }
}
