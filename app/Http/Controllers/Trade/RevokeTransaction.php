<?php

namespace App\Http\Controllers\Trade;

use App\Data\Trade\RevokeBuyData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Trade\CoinSellData;
use App\Data\Trade\TradeViewData;

class RevokeTransaction extends Controller
{
    protected $validateArray=[
        "no"=>"required",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单号!",
    ];

    /**
     * @api {post} login/trade/revoketrans 撤销二级市场挂单
     * @apiName revoketrans
     * @apiGroup Trade
     * @apiVersion 0.0.1
     * @date 2017.8.22
     *
     * @apiParam {string} no 单号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : 'TB2017***********',
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
     *      data : null   
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $no = $request['no'];
        $date = date('Y-m-d H:i:s');

        if (strpos(strval($no), strval(TradeViewData::BUY)) === 0) {
            //执行 撤销买单
            $revokeBuyData = new RevokeBuyData();
            $res = $revokeBuyData->revokeBuy($no, $date);
        } else {
            //执行撤销卖单
            $transactionSellData = new CoinSellData();
            $res = $transactionSellData->revokeSell($no, $date);
        }
        

        $this->Success();
    }
}
