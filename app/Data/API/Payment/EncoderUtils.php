<?php 
namespace App\Data\API\Payment;

use App\Data\API\Payment\XmlUtils;

class  EncoderUtils
{


    public static  function encode_req_msg($array)
    {

        $data =XmlUtils::array_to_xml($array);
        $data = EncoderUtils::str_to_gbk($data);
        $fmtmsg = base64_encode(gzencode($data));
        return $fmtmsg;

    }

    public static function decode_res_msg($msg)
    {
      
        $from64 = gzdecode(base64_decode(($msg)));
        $fmtmsg = iconv("GB2312//IGNORE", "UTF-8",  $from64);
        $result = XmlUtils::xml_to_array($fmtmsg);
        return $result;

    }



    private static  function str_to_gbk($strText)
    {
        $encode = mb_detect_encoding($strText, array('UTF-8','GB2312','GBK'));
        if($encode == "UTF-8") {
            return @iconv('UTF-8', 'GB18030', $strText);  
        }
        else
        {
            return $strText;
        }
    }
}