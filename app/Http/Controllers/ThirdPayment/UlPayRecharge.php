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
use App\Data\User\UserTypeData;
use App\Data\CashRecharge\CashRechargeFactory;

class UlPayRecharge extends Controller //step 2
{
    protected $validateArray=[
        "channelid"=>"required",
        "amount"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值金额!",
        "channelid.required"=>"请输入通道号!",
    ];

    /**
     * @api {post} login/ulpay/recharge 快捷充值
     * @apiName recharge
     * @apiGroup ulpay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} channelid 通道id
     * @apiParam {string} amount 充值金额
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      channelid : 5,
     *      amount  : 100,
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
        $amount = $request['amount'];
        $channelid = $request['channelid'];
//         $this->result =[
//                "code"=>99999,
//                "msg"=>"支付系统维护中."
 //       ];
  //      return;
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $ulpayMinAmount = $sysConfigs[UserTypeData::ULPAY_MIN_AMOUNT];
        if ($amount < $ulpayMinAmount) {
            return $this->Error(ErrorData::ULPAY_MIN_AMOUNT);
        }

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
