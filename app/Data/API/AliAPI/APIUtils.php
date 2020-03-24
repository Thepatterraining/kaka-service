<?php
namespace App\Data\API\AliAPI;

class APIUtils
{

    public static function SimpleAPI($url)
    {
 
        $response = 
            \Httpful\Request::get($url)
            ->addHeader("Authorization", "APPCODE ".config("aliyun.code"))
            ->send();
        $result =  $response->body;     
        if(isset($result->status) && $result->status  == 0  ) {
            return $result->result;
        } else if(isset($result->code)&&$result->code==0) {
            return $result->data;
        } else { 
            return null;
        }
    }
}