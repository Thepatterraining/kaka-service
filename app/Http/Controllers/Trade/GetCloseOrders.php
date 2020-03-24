<?php

namespace App\Http\Controllers\Trade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\TradeViewData;
use App\Http\Adapter\Trade\TradeViewAdapter;
use App\Data\Project\ProjectInfoData;
use App\Data\Trade\TranactionOrderData;

class GetCloseOrders extends Controller
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
     * @api {post} login/trade/getcloseorders 查询已成交列表
     * @apiName getcloseorders
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
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
     *              transCount : "1" //流入份
     *              averagePrice : 1500 //成交均价
     *              projName : "德胜房产系列001号" //项目名
     *              type : "TS" //类型 TS 卖单 TB 买单
     *              amount : 150000.00  //交易总额
     *              fee : 0 //手续费
     *              feeAmount : 1500 //流出资金
     *          },...
     *      }   
     *  }
     */
    public function run()
    {

        $pageIndex = $this->request->input('pageIndex');
        $pageSize = $this->request->input('pageSize');
        $coinType = $this->request->input('coinType');

        $tradeViewData = new TradeViewData;
        $tradeViewAdapter = new TradeViewAdapter;
        $projectData = new ProjectInfoData;
        $orderData = new TranactionOrderData;

        $orders = $tradeViewData->getCloseOrders($pageSize, $pageIndex, $coinType);

        $res = [];
        if (count($orders['items']) > 0) {
            foreach ($orders['items'] as $order) {
                $openOrdersArray = ['no','datetime','coinType','showPrice','showCount','transCount','scale','averagePrice','feePrice'];
                $order = $tradeViewAdapter->getDataContract($order, $openOrdersArray);
                //类型 买还是卖
                $order['type'] = strpos(strval($order['no']), strval(TradeViewData::BUY)) === 0 ? TradeViewData::BUY : TradeViewData::SELL;

                //查询项目名
                $project = $projectData->getByNo($order['coinType']);
                $order['projName'] = '';
                if (!empty($project)) {
                    $order['projName'] = $project->project_name;
                }
                
                $order['averagePrice'] = bcmul($order['averagePrice'], $order['scale'], 2);
                $order['transCount'] = bcdiv($order['transCount'], $order['scale'], 5);
                $order['amount'] = bcmul($order['averagePrice'], $order['transCount'], 2);

                if ($order['type'] == TradeViewData::BUY) {
                    $order['fee'] = $orderData->getBuySumFee($order['no']);
                    $order['feeAmount'] = bcadd($order['amount'], $order['fee'], 2);
                } else {
                    $order['fee'] = $orderData->getSellSumFee($order['no']);
                    $order['feeAmount'] = bcsub($order['amount'], $order['fee'], 2);
                }
                
                $res[] = $order;
                $orders['items'] = $res;
            }
        }

        $this->Success($orders);
    }
}
