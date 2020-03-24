<?php
namespace App\Http\Controllers\ThirdPayment;

use App\Data\API\Payment\OpenSwiftWechat;
use App\Data\CashRecharge\CashRechargeFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Data\Product\PreOrderData;

class ConfirmPayment extends Controller
{
    protected $json = false;
    const ZK_CHANNEL = 2;
    public function run(...$param)
    {
        $message = file_get_contents('php://input');
        Log::info($message);
        if (count($param[0]) == 0) {
            $this->result = "error";
        } else {
            $paymethod = $param[0][0];
            if ($paymethod == "swift") {
                Log::info("OpenSwiftWechat");
                $pay = new OpenSwiftWechat();
                $result = $pay->getPostResult($message);
                if ($result->result === true) {
                    $rechargeNo = $result->rechargeNo;
                    //在这里更新充值单据 为成功
                    $channelID = $result->channelId;
                    $rechargeFac = new CashRechargeFactory;
                    $rechargeData = $rechargeFac->createData($channelID);
                    $rechargeData->rechargeTrue($rechargeNo);
                    $this->result = "success";
                } else {
                    $this->result = "error";
                }
            } elseif ($paymethod == "zk") {
                Log::info("zk_payment");
                $obj = json_decode($message);
                $docno = $obj->out_trade_no; // 单据号
                $total_fee = $obj->total_fee; // 用户支付的金额
                $third_docno = $obj->tranSerial; //"WXAP201803291859120656e3c3ace_bae5_4e33_ad02_924ed4bf8fe7"
                $timeStamp = $obj->hostDate; //20180329185935
                $channel_type = $obj->channel_type; // 微信公众号支付
                Log::info($docno);
                Log::info(json_encode($obj));
                //进行支付确认
                $chkStr =  strpos($docno, "CR");
                if ($chkStr === false) {
                    // 预购
                    $preorderData = new PreOrderData();
                    $preorderData->wechatBuyProduct($docno, self::ZK_CHANNEL);
                } else {
                    //recharge
                    $rechargeFac = new CashRechargeFactory;
                    $rechargeData = $rechargeFac->createData(self::ZK_CHANNEL);
                    $rechargeData->rechargeTrue($docno);
                }
                $this->result = "success";
            }
        }
    }
}
