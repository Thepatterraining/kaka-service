<?php 
namespace App\Data\API\Payment\Ulpay;


class HttpUtil
{

    private $url ;
    
    
    public static function getPostResult($array,$code='UTF-8')
    {
    
        $url = config('3rdpay.ulpay.host');
        $data =$this->arrayToXml($array, $code);
        $data = $this->strToGBK($data);
        $sendMsg = base64_encode(gzencode($data));
        $req = \Httpful\Request::post($url)->body($sendMsg);
        $res = $req ->send(); 
        $from64 = gzdecode(base64_decode(($res->body)));
   
        $result = $this->xml_to_array(iconv("GB2312//IGNORE", "UTF-8",  $from64));
    

    }

    private static function arrayToXml($arr,$code = 'UTF-8')
    {
        $xml = "<?xml version = \"1.0\" encoding=\"".$code."\"?>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml.="<".$key.">".CheckSignUtil::arrayItemToXml($val)."</".$key.">";
            } else {
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
     
        return $xml; 
    }

    private static function arrayItemToXml($arr)
    {

        $xml = "";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml.= "<".$key.">".CheckSignUtil::arrayItemToXml($val)."</".$key.">";
            } else {
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        return $xml;
    }


   
    
}
