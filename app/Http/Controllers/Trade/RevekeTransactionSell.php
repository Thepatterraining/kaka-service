<?php

namespace App\Http\Controllers\Trade;

use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionSellData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevekeTransactionSell extends Controller
{
    protected $validateArray=[
        "transactionSellNo"=>"required|doc:sell,TS00,TS01",
    ];

    protected $validateMsg = [
        "transactionSellNo.required"=>"请输入卖单单据号!",
    ];


    /**
     * @api {post} login/trade/revoketranssell 撤销二级市场卖单
     * @apiName revoketranssell
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} transactionSellNo 买单号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      transactionSellNo : 'TS2017***********',
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
        $request = $this->request->all();
        $transactionSellNo = $request['transactionSellNo'];

        //执行撤销卖单
        $transactionSellData = new CoinSellData();
        $date = date('Y-m-d H:i:s');
        $res = $transactionSellData->revokeSell($transactionSellNo, $date);

        $this->Success();
    }
}
