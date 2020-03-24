<?php
namespace App\Data\API\AliAPI;
use App\Data\API\AliAPI\APIUtils;

class API
{


    public static function QueryMobileInfo($mobile)
    {
        $url = "http://jshmgsdmfb.market.alicloudapi.com/shouji/query?shouji={$mobile}";
        
        $result =  APIUtils::SimpleAPI($url);

     
        
            return  $result  ;
    }


    public static function QueryIpInfo($ip)
    {
        $url = "https://dm-81.data.aliyun.com/rest/160601/ip/getIpInfo.json?ip={$ip}";
        return  APIUtils::SimpleAPI($url);
        
    }


    public static function QueryIDInfo($idno)
    {
        $url = "http://jisuidcard.market.alicloudapi.com/idcard/query?idcard={$idno}";
        return  APIUtils::SimpleAPI($url);
    }
}