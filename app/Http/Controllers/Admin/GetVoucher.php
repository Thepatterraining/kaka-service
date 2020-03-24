<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\VoucherInfoData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetVoucher extends Controller
{
    /**
     * 查询所有现金券
     */
    public function run()
    {
        $data = new VoucherInfoData();
        $adapter = new VoucherInfoAdapter();
        $item = $data->getVoucher();
        $arr = [];
        foreach ($item as $k => $v) {
            $arr[] = $adapter->getDataContract($v);
        }
        $this->Success($arr);
    }
}
