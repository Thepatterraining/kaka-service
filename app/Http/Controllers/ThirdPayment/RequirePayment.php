<?php

namespace App\Http\Controllers\ThirdPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\UserRechargeData;
use App\Data\API\Payment\PaymentFactory;
use App\Data\Payment\PayChannelData;
use App\Data\CashRecharge\CashRechargeFactory;

class RequirePayment extends Controller
{

    protected $validateArray=array(
        "amount"=>"required",
        "channelid"=>"required",
    );

    protected $validateMsg = [
        "amount.required"=>"请输入充值金额!",
        "channelid.required"=>"请输入通道id!",
    ];

    /**
     * @api {post} 3rdpay/gateway 发起支付
     * @apiName get3rdgateway
     * @apiGroup 3rdPay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken accessToken
     * @apiParam {number} amount 充值金额
     * @apiParam {number} channelid 通道id
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : accessToken,
     *      amount  : 充值金额,
     *      channelid : 通道id
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
     *          codeimg : 扫码图片地址 ,
     *          codetext : 扫码提示信息 ,
     *          timelimit : 剩余支付时间 //以秒为单位,
     *          rechargeno : 支付单号,
     *
     *      }
     *  }
     */
    public function run()
    {
        //从request 取得充值金额，及通道号
        $requests = $this->request->all();
        $amount = $requests['amount'];
        $channelid = $requests['channelid'];
        
        //从道道信息取得到class
        $channelData = new PayChannelData();
        $type = $channelData->getClass($channelid);
        //充值
        $rechargeFac = new CashRechargeFactory;
        $rechargeData = $rechargeFac->createData($channelid);
        $res = $rechargeData->recharge($amount);
        if ($res['success'] === false) {
            return $this->Error($res['code']);
        }

        $rechargeNo = array_get($res, 'msg.rechargeNo');

        $fac = new PaymentFactory();
        $payMehod = $fac->create($type);

        $result = $payMehod->reqPay($amount, $rechargeNo, $channelid);

        return $this->Success($result);
        
        
    }
}
