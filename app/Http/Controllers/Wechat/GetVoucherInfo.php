<?php

namespace App\Http\Controllers\Wechat;

use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetVoucherInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:voucher_info,vaucher_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号!",
        "no.exists"=>"单据号不存在!",
        "no.string"=>"单据号必须是字符串!",
    ];

    //查找提现详细信息
    /**
     * @param no 提现单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new VoucherStorageData();
        $adapter = new VoucherStorageAdapter();

        $no = $this->request->input('no');
        $filersWhere['filters']['voucherno'] = $no;
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);

        $res = [];

        if ($item != null) {
            $res = $adapter->getDataContract($item);

            $datafac = new VoucherInfoData();
            $voucherAdapter = new VoucherInfoAdapter();

            $voucherInfo = $datafac->getByNo($res['voucherno']);
            $res['voucher'] = [];

            if ($voucherInfo != null) {
                $res['voucher'] = $voucherAdapter->getDataContract($voucherInfo);
            }
        }

        return $this->Success($res);
    }
}
