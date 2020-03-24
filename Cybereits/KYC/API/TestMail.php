<?php
namespace Cybereits\Modules\KYC\API;

use Cybereits\Modules\KYC\APIIQueryInfo;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\KYC\API\ISendMail;

class TestMail implements ISendMail
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
	    info('send tmp_id: '.$tmp_id.' mail:'.$email.' data:'.json_encode($data));
      return (Object)["result"=>true];
    }
    public function SendRegSuccessEmail($email, $name, $address,$scale)
    {
        $tmp_id = "reg_succ";
        $data = [
         "name"=>$name,
         "address"=>$address,
         "cre"=>$scale
       ];
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data->result;
    }


    public function SendAddressEmail($email, $name, $address, $id, $token,$scale,$eth)
    {
        $tmp_id = "Private_start";
        $data = [
            "token"=>$token,
            "name"=>$name,
            "ID"=>$id,
            "address"=>$address,
            "cre"=>$scale,
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

    public function SendAcceptEmail($email, $name, $idno, $acc_amount, $address,$scale)
    {
        $tmp_id = "pub_succ0";
        $id = trim($idno);
        $data = [
            "name"=>$name,
            "ID"=> substr($id, strlen($id)-4),
            "verify_amount"=>$acc_amount,
            "address"=>$address
        ];
   
        $res_data = $this->_sendEmail($tmp_id, $email, $data);
        return $res_data -> result ;
    }
    public function SendReturnEmail($email,$name,$idno,$eth,$scale,$payaddress,$address){

    }
}
