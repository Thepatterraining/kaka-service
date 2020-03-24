<?php

namespace App\Http\Controllers\ThirdPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayChannelData;
use App\Data\Product\InfoData;
use App\Http\Adapter\Pay\PayChannelAdapter;
use App\Data\API\Payment\OpenSwiftJspay;
use App\Data\CashRecharge\CashRechargeFactory;
 
class PrepareJsRecharge extends Controller
{

    private $successUrl = '';

    protected $validateArray=array(
       
        "channelid"=>"required",
        "amount"=>"required",
        "appid"=>"required",
        "openid"=>"required",

   
    );

    protected $validateMsg = [
   
        "channelid.required"=>"请输入通道id!",
        "amount.required"=>"请传入金额",
        "appid.required"=>"请传入公众号ID",
        "openid.required"=>"请传入用户ID"
    ];
    /**
     * @api {post} 3rdpay/recharge 微信端准备发起充值
     * @apiName Recharge
     * @apiGroup 3rdPay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken accessToken
     * @apiParam {string} channelid 通道编号 暂时传入值1
     * @apiParam {decimal} amount 充值金额
     * @apiParam {string} appid  公众号ID
     * @apiParam {string} openid Openid
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
     *            "jobno":"充值单号",
     *            "timelimit":1800,
     *             "token_id":"",
     *              "pay_info":"pay info"
     *      },...
     *  }
     */
    public function run()
    {

        //从request 取得充值金额，及通道号
        $requests = $this->request->all();
        $amount  = $requests['amount'];
        $channelid = $requests['channelid'];
        $appid = $requests["appid"];
        $openid = $requests["openid"];
        if ($this->request->has("success_url")) {
            $this->successUrl = $requests["success_url"];
        }
        
  
  
        $jobNo = date('YmdHis');
        
 
        //生成充值单号
        $rechargeFac = new CashRechargeFactory;
        $rechargeData = $rechargeFac->createData($channelid);
        $res = $rechargeData->recharge($amount);
        if ($res['success'] === false) {
            return $this->Error($res['code']);
        }

        $rechargeNo = array_get($res, 'msg.rechargeNo');
        
        //从道道信息取得到class  */
        $channelData = new PayChannelData();
        $pay_method = $channelData->createData($channelid);

        /** 
         * $channel_info = $channelData->getById($channelid);
         * $channel_class = $channel_info->channel_dealclass;
         * $pay_method = new $channel_class;
         * $res =   $pay_method ->reqJsPay($appid, $openid, $amount, $rechargeNo, $channelid);
         * 
         */
        /**   */
        // $type = new OpenSwiftJspay();
        // $pay_method = new $payData();
        $res = $pay_method->reqJsPay($appid, $openid, $amount, $rechargeNo, $this->successUrl);

        if ($res["success"]==true) {
            $this->Success($res["data"]);
        } else {
            $this->result = [
                "code"=>$res["code"],
                "msg"=>$res["msg"]
            ];
        }
       
    }
}
