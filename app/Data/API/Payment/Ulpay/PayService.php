<?php
namespace App\Data\API\Payment\Ulpay;

use App\Data\API\Payment\CheckSignUtil;
use App\Data\API\Payment\EncoderUtils;
use App\Data\API\Payment\IFastPaymentService;
use App\Data\API\Payment\PreparePaymentResult;
use App\Data\API\Result;
use App\Data\Utils\DocNoMaker;

class PayService implements IFastPaymentService
{

    const CODE_REQ_PAY = 100015;
    const CODE_REQ_MSG = 100016;
    const CODE_CONFIRM_PAY = 100017;
    const CODE_VALIDCARD = 100004;
    const QUERY_CARD = 10020;
    const ERROR_CODE = [
        20011036 => '暂不支持该银行，请使用其他银行的银行卡！',
    ];

    private $merchant_id = "800010001000020"; //800010000020019";

    private $_host = "http://lundroid.market.alicloudapi.com";
    private $_path = "/lianzhuo/verifi";
    private $_appCode = '9049be46241e4ca3b049e6c4ab563c81';

    public function ValidBankCard($cardno, $username, $id, $mobile)
    {
        $arrData = [
            "acct_name" => $username,
            "acct_pan"  => $cardno,
            "cert_id"   => $id,
            "phone_num" => $mobile
        ];
        $data = $this->curl_get($arrData);

        info('ali_bank_card_valid' . json_encode($data));
        $array["INFO"]["RET_CODE"] = $data->resp->code;
        $array["INFO"]["ERR_MSG"]  = $data->resp->desc;
        return $this->_getResult($array);
    }

    private function _getResult($array)
    {
        $result = new Result();
        $result->code = $array["INFO"]["RET_CODE"];
        $result->msg = $array["INFO"]["ERR_MSG"];
        $result->success = $result->code == "0000";
        return $result;

    }

    public function RequireSms($docno, $mobile)
    {

        $url = config("3rdpay.ulpay.host") . "merc-gateway-web/quickpay/sendsms";

        $data = $this->get_init_array(PayService::CODE_REQ_MSG, "2.0");
        $data["AIPG"]["BODY"] = [
            "MERCHANT_ID" => $this->merchant_id,
            "MERC_ORDER_NO" => $docno,
            "MERC_ORDER_DATE" => date("Ymd"),
            "BANK_MOBILE_NO" => $mobile,
        ];

        $array = $this->post_and_return($data, $url);

        $result = new Result();
        $result->code = $array["INFO"]["RET_CODE"];
        $result->msg = $array["INFO"]["RET_MSG"];
        $result->success = $result->code == "0000";

        return $result;
    }

    public function PreparePay($docno, $date, $amount)
    {

        $url = config("3rdpay.ulpay.host") . "merc-gateway-web/quickpay/createorder";
        // $url = "http://103.25.21.46:11110/merc-gateway-web/quickpay/createorder";

        $data = $this->get_init_array(PayService::CODE_REQ_PAY, "2.0");
        $data["AIPG"]["BODY"] = [
            "MERCHANT_ID" => $this->merchant_id,
            "MERC_ORDER_NO" => $docno,
            "MERC_ORDER_DATE" => $date,
            "TRANS_AMT" => $amount,
            "CURRENCY" => "CNY",
        ];

        $array = $this->post_and_return($data, $url);

        $result = new PreparePaymentResult();
        $result->code = $array["INFO"]["RET_CODE"];
        $result->msg = $array["INFO"]["RET_MSG"];
        $result->success = $result->code == "0000";
        if (array_key_exists($result->code, self::ERROR_CODE)) {
            $result->msg = self::ERROR_CODE[$result->code];
        }
        if ($result->success) {
            $result->thirdplatdocno = $array["BODY"]["PLAT_ORDER_NO"];
        }

        return $result;

    }

    public function ConfirmPay($docno, $docdate, $userid, $cardno, $username, $id, $mobile, $chkcode)
    {

        $url = config("3rdpay.ulpay.host") . "merc-gateway-web/quickpay/confirmpay";
        $data = $this->get_init_array(PayService::CODE_CONFIRM_PAY, "2.0");
        $data["AIPG"]["BODY"] = [
            "MERCHANT_ID" => $this->merchant_id,
            "MERC_ORDER_NO" => $docno,
            "MERC_ORDER_DATE" => $docdate,
            "MERC_USER_NO" => $userid,
            "CARD_NO" => $cardno,
            "BANK_ACCOUNT_NAME" => $username,
            "ID_TYPE" => "00",
            "ID_NO" => strtoupper($id),
            "BANK_MOBILE_NO" => $mobile,
            "MBL_CAPTCHA" => $chkcode,
        ];

        $array = $this->post_and_return($data, $url);

        $result = new Result();
        $result->code = $array["INFO"]["RET_CODE"];
        $result->msg = $array["INFO"]["RET_MSG"];
        $result->success = $result->code == "0000";
        if (array_key_exists($result->code, self::ERROR_CODE)) {
            $result->msg = self::ERROR_CODE[$result->code];
        }
        return $result;

    }

    public function GetBankCardInfo($cardno, $username, $id, $mobile)
    {
        $arrData = [
            "acct_name" => $username,
            "acct_pan"  => $cardno,
            "cert_id"   => $id,
            "phone_num" => $mobile
        ];
        $data = $this->curl_get($arrData);

        info('ali_get_bankinfo' . json_encode($data));

        $result = new Result();
        $result->code = $data->resp->code;
        $result->msg = $data->resp->desc;
        $result->bank_name = $data->data->bank_name;
        $result->bank_code = $data->data->bank_id;
        $result->success = $result->code == "0000";
        return $result;
    }

    private function get_init_array($trx_code, $version)
    {

        return [
            "AIPG" => [
                "INFO" => [
                    "TRX_CODE" => $trx_code,
                    "VERSION" => $version,
                    "DATA_TYPE" => 0,
                    "REQ_SN" => DocNoMaker::getDateSerial("al", "", 11),
                    "SIGNED_MSG" => "",

                ],

            ],
        ];
    }

    private function post_and_return($data, $url)
    {
        $SignedMsg = CheckSignUtil::GetSign($data);
        $data["AIPG"]["INFO"]["SIGNED_MSG"] = $SignedMsg;
        $sendMsg = EncoderUtils::encode_req_msg($data);
        $req = \Httpful\Request::post($url)->body($sendMsg);
        $res = $req->send();

        // dump($sendMsg);
        info('hezhong_pay');
        $result = EncoderUtils::decode_res_msg($res->body);

        $returnSign = $result["INFO"]["SIGNED_MSG"];

        $result["INFO"]["SIGNED_MSG"] = "";
        $SignedMsg = CheckSignUtil::GetSign($data);
        //dump($returnSign == $SignedMsg);
        info(json_encode($result));
        return $result;

    }

    
    private function curl_get($_aryData)
    {
        // dump($_aryData);
        $url = $this->_host . $this->_path . "?" . http_build_query($_aryData);
        $response = \Httpful\Request::get($url)
            ->addHeader("Authorization", "APPCODE {$this->_appCode}")
            ->send();
        // dump($url);
        $data = $response->body;
        return $data;
        // dump($data);
        // return $data->resp;
    }

}
