<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\IPayment;
use App\Data\Utils\DocNoMaker;
use App\Data\Utils\XmlHelper;
use App\Data\API\Payment\PayResult;
use App\Data\API\Payment\OpenSwiftPay;
use App\Data\Utils\Formater;

class OpenSwiftJspay extends OpenSwiftPay
{
    
    
    protected $pay_method = "pay.weixin.jspay";
    public function reqJsPay($appid, $openid, $amount, $jobno, $chid, $timeout = 30)
    {
        
        
        $now = date('YmdHis');
        $exp = date('YmdHis', strtotime("+{$timeout} minute"));
        $obj = array();
        $obj["service"]= $this->pay_method;
        $obj["version"]= "2.0";
        $obj["charset"]= "UTF-8";
        $obj["sign_type"]= "MD5";
        $obj["mch_id"]= $this->mc_id;
        $obj["is_raw"]="1";
        $obj["is_minipg"]="0";
        $obj["out_trade_no"]=$jobno;
        $obj["device_info"]= "001";
        $obj["body"] =  "咔咔买房购入,单号".$jobno;
        $obj["sub_openid"] = $openid;//]
        $obj["sub_appid"]=$appid;
        $obj["attach"]= $chid;
        $obj["total_fee"]=  intval(Formater::ceil($amount * 100));
        $obj["mch_create_ip"]= "127.0.0.1";
        $obj["notify_url"]= config("app.url").config("3rdpay.swift.jsurl");
        $obj["time_start"]=  $now;
        $obj["time_expire"]= $exp;
        $obj["nonce_str"]=  DocNoMaker::getRandomString(10);
        $obj["limit_credit_pay"]="1";
        $sendXML = $this->addChk($obj);

        $req = $this->execReq($sendXML);
        $msg = $req->body;
        if ($this->checkSign($msg) ===false) {
            return false;
        }
        $result =    XmlHelper :: decode($req->body);
        
        $resObj = [];
        
        if ($result["status"]=="0") {
            if ($result["result_code"]=="0") {
                return [
                "success"=>true,
                "data"=>[
                        "jobno"=>$jobno,
                        "timelimit"=>30*60,
                        "pay_info"=>$result["pay_info"]
                    ]
                ];
            } else {
                return [
                "success"=>false,
                "code"=>$result["err_code"],
                "msg"=>$result["err_msg"]
                ];
            }
        } else {
            return [
            "success"=>false,
            "code"=>$result["status"],
            "msg"=>$result["message"]
            ];
        }
    }
}
