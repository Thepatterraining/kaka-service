<?php

namespace App\Http\Controllers\ThirdPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayChannelData;
use App\Http\Adapter\Pay\PayChannelAdapter;

class GetPayMethods extends Controller
{

    
    /**
     * @api {post} 3rdpay/methods 查询支付方式
     * @apiName get3rdpayMethods
     * @apiGroup 3rdPay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken accessToken
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : accessToken,
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
     *          name : ""支付名称,
     *          payplatform : 所属支付平台,
     *          infeerate : 入账费率,
     *          infeetype : 入账费类型,
     *          outfeerate : 出账费率,
     *          outfeetype : 出账费类型,
     *          withdrawtype : {  提现类型
     *              no :
     *              name :
     *          }
     *          withdrawset : 提现周期设定,
     *          withdralbankno : 提现账号,
     *          dealclass : 处理类,
     *          ammount : 可用,
     *          pending : 在途,
     *      },...
     *  }
     */
    protected function run()
    {

        $data = new PayChannelData();
        $adapter = new PayChannelAdapter();
        $channels = $data->getPayChannels();
        $res = [];
        if (count($channels) > 0) {
            foreach ($channels as $channel) {
                $arr = $adapter->getDataContract($channel);
                $res[] = $arr;
            }
        }
        return $this->Success($res);
    }
}
