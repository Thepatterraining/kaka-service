<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetVoucherInfo extends Controller
{
    protected $validateArray=[
        "price"=>"required|integer",
        "sellNo"=>"required",
    ];

    protected $validateMsg = [
        "price.required"=>"请输入总价",
        "sellNo.required"=>"请输入卖单号",
        "price.integer"=>"总价必须是数字",
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
        $price = $request['price'];
        $sellNo = $request['sellNo'];
        //优惠券过期
        $voucherData = new VoucherStorageData;
        $voucherData->overdue();

        //查询卖单
        $sellData = new TranactionSellData();
        $sellRes = $sellData->isVoucher($sellNo);
        //不可用
        if ($sellRes === false) {
            return $this->Success();
        }

        $data = new RegVoucherData();
        $res = $data->getUserVoucher($price);
        if ($res === false || $res == null) {
            return $this->Success();
        }

        $adapter = new VoucherInfoAdapter();
        $res = $adapter->getDataContract($res);
        return $this->Success($res);
    }
}
