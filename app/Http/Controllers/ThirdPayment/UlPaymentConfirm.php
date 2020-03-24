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
use App\Data\Product\InfoData;
use App\Data\Trade\TransactionBuySellData;
use App\Data\CashRecharge\CashRechargeFactory;

class UlPaymentConfirm extends Controller //step 2
{
    private $ulpayChannelid = 5;
    
    protected $validateArray=[
        "bankCard"=>"required",
        "code"=>"required",
        "rechargeNo"=>"required",
        "count"=>"required",
        "no"=>"required",
    ];

    protected $validateMsg = [
        "bankCard.required"=>"请输入银行卡号!",
        "code.required"=>"请输入验证码!",
        "rechargeNo.required"=>"请输入充值单号!",
        "count.required"=>"请输入数量!",
        "no.required"=>"请输入卖单号!",
    ];

    /**
     * @api {post} login/ulpay/ulpaymentconfirm 快捷支付确认
     * @apiName ulpaymentconfirm
     * @apiGroup ulpay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} bankCard 银行卡号
     * @apiParam {string} code 验证码
     * @apiParam {string} rechargeNo 充值单号
     * @apiParam {string} count 购买数量
     * @apiParam {string} no 卖单号
     * @apiParam {string} paypwd 支付密码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      bankCard : '234234',
     *      code  : '1234',
     *      rechargeNo : 'CR2312',
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
     *          count : 数量,
     *          order : {
     *              price : 价格
     *              data : 时间
     *              rose : 月涨幅
     *          }
     *  }
     */
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $bankCard = $request['bankCard'];
        $code = $request['code'];
        $rechargeNo = $request['rechargeNo'];
        $no = $request['no'];
        $count = $request['count'];
        $voucherNo = '';
        if ($this->request->has('voucherNo')) {
            $voucherNo = $this->request->input('voucherNo');
        }

        //确认充值
        $cashRechargeFac = new CashRechargeFactory;
        $rechargeData = $cashRechargeFac->createData($this->ulpayChannelid, $bankCard);
        $res = $rechargeData->rechargeTrue($rechargeNo, $code);
        if (is_array($res)) {
            return $this->result = $res;
        }

        //购买产品
        $transactionBuySellData = new TransactionBuySellData;
        $res = $transactionBuySellData->buySell($no, $count, $voucherNo);

        if (is_int($res)) {
            return $this->Error($res);
        } else {
            return $this->Success($res);
        }
    }
}
