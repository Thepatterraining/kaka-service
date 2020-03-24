<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Item\QuartersData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use App\Http\Adapter\Item\QuartersAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetItemOrder extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型!",
    ];

    /**
     * 项目详情 查询项目信息
     *
     * @param   $coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.28
     */
    public function run()
    {
        $coinType = $this->request->input('coinType');
        $data = new QuartersData();
        $adapter = new QuartersAdapter();
        $item = $data->getQuarters($coinType);
        $res = [];
        if (count($item) > 0) {
            foreach ($item as $v) {
                $arr = $adapter->getDataContract($v);
                $arr['date'] = date('Y-m-d', strtotime($arr['date']));
                $res[] = $arr;
            }
        }
        $this->Success($res);
    }
}
