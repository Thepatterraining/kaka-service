<?php
namespace Cybereits\Modules\KYC\API;
use Cybereits\Modules\KYC\API\IQueryInfo;

class AliQueryInfo implements IQueryInfo {


    private  static function SimpleAPI($url)
    {
        $response = 
            \Httpful\Request::get($url)
            ->addHeader("Authorization", "APPCODE ".config("kyc.aliyun_code"))
            ->send();
        $result =  $response->body;    
//        info(json_encode($result));    
        if(isset($result->status) && $result->status  == 0  ) {
            return $result->result;
        } else if(isset($result->code)&&$result->code==0) {
            return $result->data;
        } else { 
            return $result;
        }
    }

    public  function QueryMobileInfo($mobile)
    {
        $url = "http://jshmgsdmfb.market.alicloudapi.com/shouji/query?shouji={$mobile}";
        $result =  self::SimpleAPI($url);
        return  $result  ;
    }

    public  function QueryIpInfo($ip)
    {
        $url = "https://dm-81.data.aliyun.com/rest/160601/ip/getIpInfo.json?ip={$ip}";
        return  self::SimpleAPI($url);
        
    }


    public function QueryIDInfo($idno)
    {
        $url = "http://jisuidcard.market.alicloudapi.com/idcard/query?idcard={$idno}";
        return  self::SimpleAPI($url);
    }

    static function QueryID($idno,$name){
        $url = "http://idcard.market.alicloudapi.com/lianzhuo/idcard?cardno={$idno}&name={$name}";
        return self ::SimpleAPI($url);
    }
}
