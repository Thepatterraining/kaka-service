<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashData;
use App\Http\Adapter\Sys\CashAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetSysCashInfo extends Controller
{

    //查找资金池余额信息
    /**
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CashData();
        $adapter = new CashAdapter();
        $item = $data->find();
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
