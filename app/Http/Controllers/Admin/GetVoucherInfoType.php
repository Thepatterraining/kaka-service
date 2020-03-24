<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetVoucherInfoType extends Controller
{
    /**
     * 查找现金券类型
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();
        $item = $data->getDictionaries('voucher_type');
        $arr = [];
        foreach ($item as $k => $v) {
            $arr[] = $adapter->getDataContract($v);
        }
        $this->Success($arr);
    }
}
