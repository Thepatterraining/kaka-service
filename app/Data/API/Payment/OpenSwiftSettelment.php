<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\IPayment;
use App\Data\Utils\DocNoMaker;
use App\Data\API\Payment\PayResult;
use App\Data\API\Payment\OpenSwiftPay;

class OpenSwiftSettelment extends OpenSwiftPay
{

    protected $url =  "https://download.swiftpass.cn/gateway";
    public function getSettelment($date)
    {
        $obj["service"] = "pay.bill.merchant";
        $obj["version"] = "1.0";
        $obj["bill_date"] = $date;
        $obj["bill_type"] = "ALL";
        $obj["sign_type"] = "MD5";
        $obj["mch_id"]= $this->mc_id;
        $obj["nonce_str"] =DocNoMaker::getRandomString(10);
        $obj["charset"]= "UTF-8";
        $sendXML = $this->addChk($obj);
        $req = $this->execReq($sendXML);
        return $req-> body;
    }
}
