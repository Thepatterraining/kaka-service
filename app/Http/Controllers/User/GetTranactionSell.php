<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\ItemData;
use App\Data\Item\FormulaData;
use App\Data\Project\ProjectInfoData;
use App\Data\Item\QuartersData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Data\User\UserData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class GetTranactionSell extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数",
    ];

    //管理员查询卖单
    /**
     * @param pageIndex 页码
     * @param pageSize 每页数量
     * @param status 状态
     * @param leveltype 一级市场
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $data = new TranactionSellData();
        $adapter = new TranactionSellAdapter();
        $projectInfoData = new ProjectInfoData();
        $formulaData = new FormulaData();
        $quartersData = new QuartersData();
        $orderData = new TranactionOrderData();
        //        $filters = $adapter->getFilers($request);
        $order = $adapter->getFilers($request);
        $filters = $adapter->getFilers($request);
        $item = $data->getSellOrder($pageSize, $pageIndex, $filters);
        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            // $arr['item'] = $projectInfoData->getByNo($arr['cointype']);
            $arr['item']['cover_img1'] = $formulaData->getLayoutImg($arr['cointype'], FormulaData::$FORMULA_LOCATION_MAP_IMG_TYPE);
            $arr['item']['quarters'] = $quartersData->getQuartersList($arr['cointype']);
            $arr['order'] = $orderData->getInfo($arr['cointype']);
            if ($arr['status']['no'] != 'TS02') {
                $arr['count'] = $arr['count'] - $arr['transcount'];
            }
            $arr['amount'] = $arr['count'] * $arr['limit'];
            $arr['amount'] = sprintf("%.2f", $arr['amount']);
            $arr['limit'] = sprintf("%.2f", $arr['limit']);
            $res[] = $arr;
        }

        $item['items'] = $res;
        $this->Success($item);
    }
}
