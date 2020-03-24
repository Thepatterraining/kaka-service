<?php
namespace App\Data\API\Utils;

class HttpUtils
{


    public static function getJson($url)
    {
        $response = \Httpful\Request::get($url)->send();
        return $response -> body;
    }
    public static function postJson($url,$data)
    {

        $response = \Httpful\Request::post($url)                  // Build a PUT request...
        ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
        ->authenticateWith('username', 'password')  // authenticate with basic auth...
        ->body(json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK))             // attach a body/payload...
        ->send();                
        return   $response -> body;
    }
     
}