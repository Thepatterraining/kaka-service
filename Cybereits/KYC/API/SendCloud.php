<?php
namespace Cybereits\Modules\KYC\API;

use Cybereits\Modules\KYC\APIIQueryInfo;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\KYC\API\ISendMail;

class SendCloud implements ISendMail
{
    public function SendCheckCodeEmail($email, $code)
    {
        $data =[
            "checkcode"=>$code
        ];
        $tmp_id = "CheckCodeMail";
        $req_result = $this->_sendEmail($tmp_id, $email, $data);
        return $req_result -> result;
    }

    private function _sendEmail($tmp_id, $email, $data)
    {
        $url = "http://api.sendcloud.net/apiv2/mail/sendtemplate";
        $postData = [
         "apiUser"=>config("mail.username"),
         "apiKey"=>config("mail.password"),
         "from"=>config("mail.from.address"),
         "templateInvokeName"=>$tmp_id,
         "to"=>$email,
       ];
        $postUrl = $url ;
        $sub=[];
        foreach ($data as $key => $val) {
            $valkey = "%".$key."%";
            $sub[$valkey]=[$val];
        }
        $postData["xsmtpapi"]=json_encode([
        "to"=>[$email],
        "sub"=>$sub]);
        $postUrl = $postUrl."?".http_build_query($postData);
        return HttpHelper::postJson($postUrl, $postData);
    }
    public function SendRegSuccessEmail($email, $name, $address,$scale)
    {
        $tmp_id = "pub_reg_succ";
        $data = [
         "name"=>$name,
         "address"=>$address,
         "cre"=>$scale
       ];
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data->result;
    }


    public function SendAddressEmail($email, $name, $address, $id, $token,$cre,$eth)
    {
        $tmp_id = "pub_Private_start";
        $data = [
            "token"=>$token,
            "name"=>$name,
            "ID"=>$id,
            "address"=>$address,
            "cre"=>$cre,
            "res_cre"=>$eth,
        ];
        $res_data = $this->_sendEmail(
            $tmp_id,
            $email,
            $data
        );
        return $res_data -> result;
    }

    public function SendReport($email, $amount)
    {
        $tmp_id = "ICO_Report";
        $data = [
            "time"=> date("Y-m-d H:i:s"),
            "amount"=>$amount,
        ];
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data -> result;
    }

    public function SendAcceptEmail($email, $name, $idno, $acc_amount, $address,$cre)
    {
        $tmp_id = "succ1";
        $id = trim($idno);
        $data = [
            "name"=>$name,
            "ID"=> substr($id, strlen($id)-4),
            "verify_amount"=>$acc_amount,
            "address"=>$address,
            "cre"=>$cre,
	    "receive_amount"=>$acc_amount,
        ];
   
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data -> result ;
    }

    public function SendReturnEmail($email,$name,$idno,$eth,$scale,$payaddress,$address){

        $tmp_id = "Return";
        $id = trim($idno);
        $data = [
            "name"=>$name,
            "ID"=> substr($id, strlen($id)-4),
            "ETH"=>$eth,
            "cre"=>$scale,
            "C_adress"=>$payaddress,
            "U_adress"=>$address,
        ];
   
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data -> result ;

    }
}
