<?php

namespace App\Http\Controllers\Trade;

use App\Data\Trade\RevokeBuyData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevokeTransactionBuy extends Controller
{
    protected $validateArray=[
        "transactionBuyNo"=>"required|doc:buy,TB00,TB01",
    ];

    protected $validateMsg = [
        "transactionBuyNo.required"=>"请输入买单单据号!",
    ];

    /**
     * @api {post} login/trade/revoketransbuy 撤销二级市场买单
     * @apiName revoketransbuy
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} transactionBuyNo 买单号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      transactionBuyNo : 'TB2017***********',
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
        $transactionBuyNo = $request['transactionBuyNo'];

        //执行
        $revokeBuyData = new RevokeBuyData();
        $date = date('Y-m-d H:i:s');
        $res = $revokeBuyData->revokeBuy($transactionBuyNo, $date);

        $this->Success();
    }
}
