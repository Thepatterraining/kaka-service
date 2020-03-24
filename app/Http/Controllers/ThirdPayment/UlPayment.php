<?php

namespace App\Http\Controllers\ThirdPayment;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;
use App\Data\User\UserBankCardData;
use App\Data\Sys\ErrorData;
use App\Data\API\Payment\PaymentServiceFactory ; 
use App\Data\Payment\UlPayData;
use App\Data\Product\PreOrderData;
use App\Data\CashRecharge\CashRechargeFactory;

class UlPayment extends Controller //step 2
{
    protected $validateArray=[
        "channelid"=>"required",
        "count"=>"required",
        "no"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值金额!",
        "channelid.required"=>"请输入通道号!",
        "count.required"=>"请输入数量!",
        "no.required"=>"请输入卖单号!",
    ];

    /**
     * @api {post} login/ulpay/ulpayment 快捷支付
     * @apiName ulpayment
     * @apiGroup ulpay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} channelid 通道id
     * @apiParam {string} no 卖单号
     * @apiParam {string} count 数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      channelid : 5,
     *      no  : '123',
     *      count : 1
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
     *      data : '123'
     *  }
     */
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $no = $request['no'];
        $channelid = $request['channelid'];
        $count = $request['count'];

        //开始充值
        $UlPay = new UlPayData();
        $preOrderData = new PreOrderData;
        $amount = $preOrderData->getSellAmount($no, $count);
        //开始充值
        $cashRechargeFac = new CashRechargeFactory;
        $rechargeData = $cashRechargeFac->createData($channelid);
        $res = $rechargeData->recharge($amount);

        if (is_array($res)) {
            return $this->result = $res;
        }
        return $this->Success($res);
    }
}
