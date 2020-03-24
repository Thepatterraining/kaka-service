<?php

namespace App\Http\Controllers\Trade;

use App\Data\Sys\ErrorData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Data\Trade\TransactionBuySellData;

class TranactionBuySell extends Controller
{
    protected $validateArray=[
        "count"=>"numeric",
        "no"=>"required|doc:sell,TS00,TS01",
    ];

    protected $validateMsg = [
        "count.required"=>"请输入买单数量!",
        "no.required"=>"请输入卖单单据号!",
        "count.numeric"=>"买入数量请输入数字!",
    ];

    /**
     * @api {post} login/trade/transbuysell 购买指定卖单
     * @apiName transbuysell
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} count 购买数量
     * @apiParam {string} no 卖单号
     * @apiParam {string} paypwd 支付密码
     * @apiParam {string} voucherNo 优惠券号 可选
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      voucherNo : '123123112',
     *      count : 1,
     *      no : '123123112312',
     *      paypwd : '123qweASD'
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
     *      data :  {
     *          count : 数量
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $no = $request['no'];
        $voucherNo = '';
        if ($this->request->has('voucherNo')) {
            $voucherNo = $this->request->input('voucherNo');
        }
        $count = 0;
        if ($this->request->has('count')) {
            $count = $request['count'];
        }
        $count = intval($count);

        $transactionBuySellData = new TransactionBuySellData;
        $res = $transactionBuySellData->buySell($no, $count, $voucherNo);

        //返回
        if (is_int($res)) {
            return $this->Error($res);
        } else {
            return $this->Success($res);
        }
    }
}
