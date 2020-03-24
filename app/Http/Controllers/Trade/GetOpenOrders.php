<?php

namespace App\Http\Controllers\Trade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TradeViewData;
use App\Http\Adapter\Trade\TradeViewAdapter;
use App\Data\Project\ProjectInfoData;

class GetOpenOrders extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required|numeric",
        "pageSize"=>"required|numeric",
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "coinType.required"=>"请输入代币类型",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.numeric"=>"页码必须是整形",
        "pageSize.numeric"=>"每页数量必须是整形",
    ];

    /**
     * @api {post} login/trade/getopenorders 查询未成交列表
     * @apiName getopenorders
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : '1',
     *      pageSize : '10',
     *      coinType : 'KKC-BJ0001'
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *          {
     *              no : "TS2017081819265261858" //单号
     *              datetime : "2017-08-18 19:26:52" //时间
     *              coinType : "KKC-BJ0001 //代币类型
     *              showPrice : "1500" //委托价格
     *              showCount : "1" //委托数量
     *              transCount : "1" //成交数量
     *              projName : "德胜房产系列001号" //项目名
     *              type : "TS" //类型 TS 卖单 TB 买单
     *          },...
     *      }   
     *  }
     */
    public function run()
    {
        $coinType = $this->request->input('coinType');
        $pageIndex = $this->request->input('pageIndex');
        $pageSize = $this->request->input('pageSize');

        $tradeViewData = new TradeViewData;
        $tradeViewAdapter = new TradeViewAdapter;
        $projectData = new ProjectInfoData;

        $orders = $tradeViewData->getOpenOrders($coinType, $pageIndex, $pageSize);

        $res = [];
        if (count($orders['items']) > 0) {
            foreach ($orders['items'] as $order) {
                $openOrdersArray = ['no','datetime','coinType','showPrice','showCount','transCount','scale','averagePrice'];
                $order = $tradeViewAdapter->getDataContract($order, $openOrdersArray);
                //类型 买还是卖
                $order['type'] = strpos(strval($order['no']), strval(TradeViewData::BUY)) === 0 ? TradeViewData::BUY : TradeViewData::SELL;

                //查询项目名
                $project = $projectData->getByNo($order['coinType']);
                $order['projName'] = '';
                if (!empty($project)) {
                    $order['projName'] = $project->project_name;
                }
                
                $order['averagePrice'] *= $order['scale'];
                $order['transCount'] = bcdiv($order['transCount'], $order['scale'], 5);
                $res[] = $order;
                $orders['items'] = $res;
            }
        }

        $this->Success($orders);
    }
}
