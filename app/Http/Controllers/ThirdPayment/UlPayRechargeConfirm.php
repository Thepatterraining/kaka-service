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
use App\Data\CashRecharge\CashRechargeFactory;

class UlPayRechargeConfirm extends Controller //step 2
{

    private $ulpayChannelid = 5;

    protected $validateArray=[
        "bankCard"=>"required",
        "code"=>"required",
        "rechargeNo"=>"required",
    ];

    protected $validateMsg = [
        "bankCard.required"=>"请输入银行卡号!",
        "code.required"=>"请输入验证码!",
        "rechargeNo.required"=>"请输入充值单号!",
    ];

    /**
     * @api {post} login/ulpay/rechargeconfirm 快捷充值确认
     * @apiName rechargeconfirm
     * @apiGroup ulpay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} bankCard 银行卡号
     * @apiParam {string} code 验证码
     * @apiParam {string} rechargeNo 充值单号
     * @apiParam {string} paypwd 支付密码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      bankCard : '234234',
     *      code  : '1234',
     *      rechargeNo : 'CR2312',
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
     *      data : null
     *  }
     */
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $bankCard = $request['bankCard'];
        $code = $request['code'];
        $rechargeNo = $request['rechargeNo'];

        //确认充值
        $cashRechargeFac = new CashRechargeFactory;
        $rechargeData = $cashRechargeFac->createData($this->ulpayChannelid, $bankCard);
        $res = $rechargeData->rechargeTrue($rechargeNo, $code);

        if (is_array($res)) {
            return $this->result = $res;
        }
        return $this->Success($res);
    }
}
