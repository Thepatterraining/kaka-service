<?php

namespace App\Http\Controllers\Trade;

use App\Data\Sys\ErrorData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Rank\OrderList;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;

class GetTransactions extends Controller
{

    /**
     * @api {post} token/trade/gettransactions 查询买单卖单列表
     * @apiName gettransactions
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型
     * @apiParam {string} count 获取的数量 选填 默认为5条
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinType : 'KKC-BJ0001',
     *      count    : 5,
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
     *              buys : {
     *                  'price' : '255.000', //价格
     *                  'count' : '1.000000000000', //数量
     *              },
     *              sells : {
     *                  'price' : '255.000', //价格
     *                  'count' : '1.000000000000', //数量
     *              },
     *              newOrderPrice : 1900 //最新成交价
     *      }   
     *  }
     */
    public function run()
    {
        //接收数据
        $count = 5;
        if ($this->request->has('count')) {
            $count = $this->request->input('count');
        }
        $coinType = $this->request->input('coinType');
        //查询
        $orderList = new OrderList($coinType);
        $sellData = new TranactionSellData();

        $buys = $orderList->GetBuy($count);

        //卖单
        $sells = $sellData->GetSell($count);

        //最新成交价
        $orderData = new TranactionOrderData;
        $newOrderPrice = $orderData->getOrderPrice($coinType);
        
        $res['buys'] = $buys;
        $res['sells'] = $sells;
        $res['newOrderPrice'] = $newOrderPrice;

        $this->Success($res);
    }
}
