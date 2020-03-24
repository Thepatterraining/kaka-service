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
use App\Data\User\BankAccountData;

class UlPayRechargeSms extends Controller //step 2
{
    protected $validateArray=[
        "bankCard"=>"required",
        "rechargeNo"=>"required",
    ];

    protected $validateMsg = [
        "rechargeNo.required"=>"请输入充值单号!",
        "bankCard.required"=>"请输入银行卡号!",
    ];

    /**
     * @api {post} login/ulpay/rechargesms 快捷充值短信
     * @apiName rechargesms
     * @apiGroup ulpay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} bankCard 银行卡号
     * @apiParam {string} rechargeNo 充值单号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      bankCard : '132****42',
     *      rechargeNo : 'CR2312',
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
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $rechargeNo = $request['rechargeNo'];
        $bankCard = $request['bankCard'];

        $userBankCardData = new BankAccountData;
        $mobile = $userBankCardData->getMobile($bankCard);

        //开始充值
        $UlPay = new UlPayData();
        $res = $UlPay->sendSms($rechargeNo, $mobile);

        if (is_array($res)) {
            return $this->result = $res;
        }

        return $this->Success($res);
    }
}
