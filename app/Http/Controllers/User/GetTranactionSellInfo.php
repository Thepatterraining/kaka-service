<?php

namespace App\Http\Controllers\User;

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

    //用户查询卖单信息
    /**
     * @param no 卖单单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $userId = $this->session->userid;
        $sellNo = $request['no'];
        $data = new TranactionSellData();
        $adapter = new TranactionSellAdapter();
        $dictionaryData = new DictionaryData();
        $dictionaryAdapter = new DictionaryAdapter();
        $filter['filters']['userid'] = $userId;
        $filter['filters']['no'] = $sellNo;
        $filers = $adapter->getFilers($filter);
        $item = $data->find($filers);
        $item = $adapter->getDataContract($item);
        $filter['filters']['type'] = $item['status'];
        $filers = $dictionaryAdapter->getFilers($filter);
        $type = $dictionaryData->find($filers);
        $item['status'] = $dictionaryAdapter->getDataContract($type, ['name']);
        $filter['filters']['type'] = $item['leveltype'];
        $filers = $dictionaryAdapter->getFilers($filter);
        $type = $dictionaryData->find($filers);
        $item['leveltype'] = $dictionaryAdapter->getDataContract($type, ['name']);
        $this->Success($item);
    }
}
