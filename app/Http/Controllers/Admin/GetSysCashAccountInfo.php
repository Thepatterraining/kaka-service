<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSysCashAccountInfo extends Controller
{
    //查找平台余额信息
    /**
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashAccountData();
        $adapter = new CashAccountAdapter();
        $item = $data->find();
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
