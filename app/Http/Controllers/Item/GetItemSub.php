<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetItemSub extends Controller
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
        $data = new InfoData();
        $orderData = new TranactionOrderData();
        $item = $data->getItem($coinType);
        if ($item == null) {
            return $this->Error(809001);
        }
        $adapter = new InfoAdapter();
        $item = $adapter->getDataContract($item, ['sublet','rightDate','bonusDate']);
        if ($item['sublet'] == 'IS01') {
            //按季租
            $rightDate = [];
            $bonusDate = [];
            $date = $item['rightDate'];
            $bonus = $item['bonusDate'];
            if ($date != '1970-01-01 00:00:00' && $bonus != '1970-01-01 00:00:00') {
                $rightDate[] = date('Y-m-d', strtotime($date));
                $bonusDate[] = date('Y-m-d', strtotime($bonus));
                for ($i = 0;; $i++) {
                    if ($i >= 3) {
                        break;
                    }
                    $date = date('Y-m-d', strtotime($date . " + 3 month"));
                    $rightDate[] = $date;
                    $bonus = date('Y-m-d', strtotime($bonus . " + 3 month"));
                    $bonusDate[] = $bonus;
                }
            }
        } elseif ($item['sublet'] == 'IS02') {
            //按年租
            $date = $item['rightDate'];
            $bonus = $item['bonusDate'];
            if ($date != '1970-01-01 00:00:00' && $bonus != '1970-01-01 00:00:00') {
                $rightDate[] = $date;
                $bonusDate[] = $bonus;
            }
        }
        $res['rightDate'] = $rightDate;
        $res['bonusDate'] = $bonusDate;
        $this->Success($res);
    }
}
