<?php
namespace App\Data\API\Payment\ZKXinlong;

use App\Data\API\Payment\CheckSignUtil;
use App\Data\API\Payment\IPayment;

class PayService implements IPayment
{

    private $url = "https://pay.zkxinlong.com/api/pay.mt";
    private $merchant_id = "500124";

    const HOST = 'https://wx.kakamf.com/pay/?#/';
    /**
     * 发起支付
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.9
     */

    /** reqJsPay($appid, $openid, $amount, $jobNo, $channelid); */
    /**
     * 发起支付
     * @param $appid
     * @param $openid
     * @param $amount
     * @param $jobno
     * @param $successUrl
     * @param $timeout
     */
    public function reqJsPay($appid, $openid, $amount, $jobno, $successUrl, $timeout = 60)
    {

        $params = [
            "merch_id" => $this->merchant_id,
            "method" => "ZKWXMPPY",
            "payment" => "07",
            "body" => "咔咔买房购入,单号".$jobno,
            "out_trade_no" => $jobno,
            "total_fee" => $amount,
            "sub_openid" => $openid,
            "spbill_create_ip" => "127.0.0.1",
            "notify_url" => config("app.url") . config("3rdpay.zkpay.url"),
            "sub_appid" => config("wechat.appid"),
            "callback_url" => self::HOST . $successUrl,

        ];

        $obj = $this->_post_and_return($params);

        if ($obj->success === true) {
            return [
                "success" => true,
                "data" => [
                    "pay_url" => $obj->payUrl,
                    "jobno" => $jobno,
                ],
            ];
        } else {

            return [
                "success" => false,
                "code" => $obj->error_code,
                "msg" => $obj->error_message,
            ];

        }

    }
    /**
     * 查询支付状态
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.0
     */
    public function queryStatus($jobno)
    {

    }

    /**
     * 检查签名是否正确
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.0
     */
    public function checkSign($data)
    {

    }

    /**
     * 得到数据
     *
     * @author geyunfei (geyunfei@kakamf.com)
     */
    public function getData($raw)
    {

    }

    /**
     * 得到通知结果
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @date    2017.5.18
     * @version 1.0
     **/
    public function getPostResult($raw)
    {

    }
    private function _join_str($data)
    {
        ksort($data);
        $msg = "";
        foreach ($data as $k => $v) {

            $fmt_str = ltrim(rtrim($v)); /// remove the empty string
            if ($fmt_str != "") {
                $msg = $msg . "&" . $k . "=" . $fmt_str;
            }

        }
        $msg = substr($msg, 1);
        return $msg;
    }

    private function _check_sign($data)
    {
    }
    private function _post_and_return($data)
    {
        $SignedMsg = CheckSignUtil::GetZKSign($data);
        $data["sign"] = $SignedMsg;
        $sendMsg = $this->_join_str($data);
        $req = \Httpful\Request::post($this->url)->body($sendMsg);
        $res = $req->send();
        $result = $res->body;
        $obj = json_decode($result);
        return $obj;
    }

}
