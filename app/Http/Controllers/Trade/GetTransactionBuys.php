<?php

namespace App\Http\Controllers\Trade;

use App\Data\Sys\ErrorData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Rank\OrderList;

class GetTransactionBuys extends Controller
{

    /**
     * @api {post} token/trade/getbuys 查询买单列表
     * @apiName getbuys
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
     *              {
     *                  'price' : '255.000', //价格
     *                  'count' : '1.000000000000', //数量
     *              },...
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
        $buys = $orderList->GetBuy($count);

        $this->Success($buys);
    }
}
