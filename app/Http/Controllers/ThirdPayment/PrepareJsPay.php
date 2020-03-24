<?php

namespace App\Http\Controllers\ThirdPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayChannelData;
use App\Data\Product\InfoData;
use App\Http\Adapter\Pay\PayChannelAdapter;
use App\Data\API\Payment\OpenSwiftJspay;
use App\Data\Product\PreOrderData;
 
class PrepareJsPay extends Controller
{

    
    protected $validateArray=array(
        "no"=>"required",
        "channelid"=>"required",
        "count"=>"required",
        "appid"=>"required",
        "openid"=>"required",
        "success_url"=>"required",
   
    );

    protected $validateMsg = [
        "no.required"=>"没有选择要购买的卖单",
        "channelid.required"=>"请输入通道id!",
        "count.required"=>"请传入购买数量",
        "appid.required"=>"请传入公众号ID",
        "openid.required"=>"请传入用户ID",
        "success_url.required"=>"请传入成功的回调url"
    ];
    /**
     * @api {post} 3rdpay/prepare 准备第三方支付
     * @apiName PreparePay
     * @apiGroup 3rdPay
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken accessToken
     * @apiParam {string} no 产品编号
     * @apiParam {string} channelid 通道编号
     * @apiParam {int} count 购买数量
     * @apiParam {string} appid  公众号ID
     * @apiParam {string} openid Openid
     * @apiParam {string} voucherNo 代金券号 可选
     * @apiParam {string} success_url 支付成功的回调url
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : accessToken,
     *      no : 'TS2017********',
     *      channelid : 1,
     *      count : 1,
     *      appid : 'appid',
     *      openid : 'openid',
     *      voucherNo : 'voucherNo'
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
     *            "jobno":"预购单号",
     *           "timelimit":1800,
     *             "token_id":"",
     *              "pay_info":"pay info"
     *      },...
     *  }
     */
    public function run()
    {

        //从request 取得充值金额，及通道号
        $requests = $this->request->all();
        $count = $requests['count'];
        $channelid = $requests['channelid'];
        $appid = $requests["appid"];
        $openid = $requests["openid"];
        $no = $requests["no"];
        $successUrl = $requests["success_url"];

        $voucherNo = '';
        if ($this->request->has('voucherNo')) {
            $voucherNo = $this->request->input('voucherNo');
        }
        $openid = $requests["openid"];
        $amount = 1;
        $jobNo = date('YmdHis');
        
       
        //中得计算得到单号和金额
        $infoData = new InfoData();
        $preorderData = new PreOrderData();

        $preRes = $preorderData->wechatBuyPreProduct($no, $count, $voucherNo);

        $amount = $preRes['amount'];
        $jobNo = $preRes['preNo'];
        
        //从道道信息取得到class  */
        $channelData = new PayChannelData();
        $pay_method = $channelData->createData($channelid);
        // $channelData = new PayChannelData();
        // $type = new OpenSwiftJspay();// $channelData->getClass("swift.jspay");



        /**  */
        $res = $pay_method->reqJsPay($appid, $openid, $amount, $jobNo, $successUrl);

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
