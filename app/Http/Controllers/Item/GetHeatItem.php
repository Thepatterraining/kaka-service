<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\FormulaData;
use App\Data\Project\ProjectInfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetHeatItem extends Controller
{

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
        $data = new ProjectInfoData();
        $orderData = new TranactionOrderData();
        $orderAdapter = new TranactionOrderAdapter();
        $orderInfo = $orderData->getHeat(0, 5);
        //        dump($orderInfo);
        //        if ($orderInfo->isEmpty()) {
        //            $res = [];
        //        } else {
        $res  = [];
        foreach ($orderInfo as $k => $v) {
            //                $order = $orderAdapter->getDataContract($v,['count','type']);
            $res[$k]['coinType'] = $v->order_coin_type;
            $res[$k]['sumcount'] = $v->sumcount;
            $projectInfo = $data->getByNo($v->order_coin_type);
            $res[$k]['name'] = empty($projectInfo) ? '' : $projectInfo->project_name;
        }
        //        }

        $this->Success($res);
    }
}
