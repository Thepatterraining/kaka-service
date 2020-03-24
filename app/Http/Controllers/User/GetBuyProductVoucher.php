<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;

class GetBuyProductVoucher extends Controller
{
    protected $validateArray=[
        "count"=>"required",
        "no"=>"required|doc:sell,TS00,TS01",
    ];

    protected $validateMsg = [
        "count.required"=>"请输入数量",
        "no.required"=>"请输入卖单号",
    ];

    /**
     * 查询卖单可用券
     *
     * @param   price 总价
     * @param   sellNo 卖单号
     * @authro  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $count = $request['count'];
        $sellNo = $request['no'];

        //查询产品得到卖单号
        $voucherStorageData = new VoucherStorageData();
        $voucherStorageAdapter = new VoucherStorageAdapter();
        
        //查询卖单
        $sellData = new TranactionSellData();
        $sellRes = $sellData->isVoucher($sellNo);
        //不可用
        if ($sellRes === false) {
            return $this->Success();
        }

        $data = new RegVoucherData();
        $res = $data->getUserProductVoucher($count, $sellNo);
        if (empty($res)) {
            return $this->Success();
        }

        $adapter = new VoucherInfoAdapter();
        $res = $adapter->getDataContract($res);
        $voucherNo = array_get($res, 'no');
        $voucherStorage = $voucherStorageData->getStorage($voucherNo);
        $voucherStorage = $voucherStorageAdapter->getDataContract($voucherStorage);
        $res['voucherStorageNo'] = $voucherStorage['no'];


        return $this->Success($res);
    }
}
