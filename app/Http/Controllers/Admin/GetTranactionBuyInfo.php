<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionBuyData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionBuyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTranactionBuyInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:transaction_buy,buy_no",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入买单单据号",
        "no.exists:transaction_buy,buy_no"=>"买单单据号不存在",
    ];

    //管理员查询买单详细
    /**
     * @param no 买单单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $buyNo = $request['no'];
        $data = new TranactionBuyData();
        $adapter = new TranactionBuyAdapter();
        $item = $data->getByNo($buyNo);
        $res = $adapter->getDataContract($item);
        $this->Success($res);
    }
}
