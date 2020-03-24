<?php
namespace App\Data\API\Payment;


use App\Data\API\Payment\XmlUtils;

class CheckSignUtil
{




   

    public static function GetSign($array)
    {

        $url = config("3rdpay.ulpay.signhost");
       $data =XmlUtils::array_to_xml($array);
        $sendMsg = json_encode(
            [
            "Msg"=>$data], JSON_UNESCAPED_UNICODE
        );            
            $req = \Httpful\Request::post($url)
                    -> sendsJson()       
                    ->body($sendMsg);
                    $res = $req ->send();
            $singedResult =  $res->body;
            return $singedResult->SignedMsg;

    }
    

    public static function GetZkSign($array){
        $url  = config("3rdpay.zkpay.signhost");

        $data  = self :: _join_str($array);

        $sendMsg = json_encode(
            [
            "Msg"=>$data], JSON_UNESCAPED_UNICODE
        );            
            $req = \Httpful\Request::post($url)
                    -> sendsJson()       
                    ->body($sendMsg);
                    $res = $req ->send();
            $singedResult =  $res->body;
            return $singedResult->SignedMsg;
        



    }

    private static function _join_str($data){
        ksort($data);
        $msg = "";
        foreach ($data as $k => $v) {
            
            $fmt_str = ltrim(rtrim($v)); /// remove the empty string 
            if($fmt_str != "")
                $msg = $msg."&".$k."=".$fmt_str;
        }
        $msg=substr($msg, 1);
        return $msg ;

    }

}
