<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\IPayment;
use App\Data\Utils\DocNoMaker;
use App\Data\Utils\XmlHelper;
use Illuminate\Support\Facades\Log;
use App\Data\Utils\Formater;

abstract class OpenSwiftPay implements IPayment
{
    
    protected $mc_id;
    protected $app_key;
    protected $pay_method ;
    protected $pay_msg ;
    protected $url =  "https://pay.swiftpass.cn/pay/gateway";
    function reqPay($amount, $jobno, $chid, $timeout = 30)
    {
        
        $now = date('YmdHis');
        $exp = date('YmdHis', strtotime("+{$timeout} minute"));
        $obj = array();
        $obj["service"]= $this->pay_method;
        $obj["version"]= "2.0";
        $obj["charset"]= "UTF-8";
        $obj["sign_type"]= "MD5";
        $obj["mch_id"]= $this->mc_id;
        $obj["out_trade_no"]=$jobno;
        $obj["device_info"]= "001";
        $obj["body"] =  "咔咔买房充值,单号".$jobno;
        $obj["attach"]= $chid;
        $obj["total_fee"]=  intval(Formater::ceil($amount * 100));
        $obj["mch_create_ip"]= "127.0.0.1";
        $obj["notify_url"]= config("app.url").config("3rdpay.swift.url");
        $obj["time_start"]=  $now;
        $obj["time_expire"]= $exp;
        $obj["nonce_str"]=  DocNoMaker::getRandomString(10);
        $obj["limit_credit_pay"]="1";
        $sendXML = $this->addChk($obj);

   
        $req = $this->execReq($sendXML);
        $msg = $req->body;
      
        if ($this->checkSign($msg) ===false) {
             return [
                "success"=>false,
                "code"=>809999,
                "msg"=>'支付系统校验出错,请稍后重试'
                ];
           
        }
        $result =    XmlHelper :: decode($req->body);
        
        return [
        
        "timelimit"=>30*60,
        "codetext"=>$this->pay_msg,
        "rechargeno"=>$jobno,
        "codeimg"=>$result["code_img_url"]
        
        ];
    }
 
    function queryStatus($jobno)
    {
    }
    

    
    public function checkSign($data)
    {
        
        
        
        $obj = XmlHelper :: decode($data);
        
        return $this->checkSignXml($obj);
    }
    
    

    public function getData($raw)
    {
        
        $obj = XmlHelper :: decode($raw);
        return $obj;
    }
    
    
    public function getPostResult($raw)
    {
        
        $result = new PayResult();
        
        $xml =  $this->getData($raw);
   
        Log::info($xml);
        
        $result->result =  $xml["status"] === "0";
        if ($result->result === true) {
            $result->result  = $result->result  &&  $this->checkSignXml($xml);
        }
        if ($result->result === true) {
            $result->result = $result->result && $xml["result_code"] === "0";
        }
        
        if ($result->result === true) {
            $result->result = $result->result &&  $xml["pay_result"] ==="0" ;
        }
        
        
        if ($result->result === true) {
            $result->rechargeNo = $xml["out_trade_no"];
            $result->channelId = $xml["attach"];
        }
        
        return $result ;
    }
    
    protected function execReq($body)
    {
        
        $url = $this->url;
        $req = \Httpful\Request::post($url)->body($body);
        $res = $req ->send();
        return $res;
    }
    public function __construct()
    {
        
        $this->mc_id = config('3rdpay.swift.appid');
        $this->app_key = config('3rdpay.swift.key');
    }
    protected function checkSignXml($obj)
    {
        $removeArray = [
        "sign"=>""
        ];
        if(array_key_exists("sign", $obj)===false) {
            return false;
        }
        $Sign = $obj["sign"];
        $result = array_diff_key($obj, $removeArray);
        $computeSign = $this->getChk($result);
        return $Sign === $computeSign;
    }
    
    public function addChk($obj)
    {
        
        $obj["sign"]=$this->getChk($obj);
        $sendXML = $this->arrayToXml($obj);
        return $sendXML;
    }
    protected function getChk($obj)
    {
        
        
        ksort($obj);
        $str2Md5 = "";
        foreach ($obj as $key => $val) {
            $str2Md5 = $str2Md5."&".$key."=".$val;
        }
        $str2Md5 = substr($str2Md5, 1);
        
        $str2Md5 = $str2Md5."&key=".$this->app_key;
        // dump($str2Md5);
        return strtoupper(MD5($str2Md5));
    }
    
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}
