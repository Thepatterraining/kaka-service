<?php

namespace App\Http\Controllers\User;

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

    //用户查询买单详细
    /**
     * @param no 买单单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $buyNo = $request['no'];
        $data = new TranactionBuyData();
        $adapter = new TranactionBuyAdapter();
        $dictionaryData = new DictionaryData();
        $dictionaryAdapter = new DictionaryAdapter();
        $filter['filters']['userid'] = $userId;
        $filter['filters']['no'] = $buyNo;
        $filers = $adapter->getFilers($filter);
        $item = $data->find($filers);
        $arr = $adapter->getDataContract($item);
        $filter['filters']['type'] = $arr['status'];
        $filers = $dictionaryAdapter->getFilers($filter);
        $type = $dictionaryData->find($filers);
        $arr['status'] = $dictionaryAdapter->getDataContract($type, ['name']);
        $this->Success($arr);
    }
}
