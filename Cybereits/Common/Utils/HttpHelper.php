<?php
namespace Cybereits\Common\Utils;

class HttpHelper
{
    public static function getJson($url)
    {
        $response = \Httpful\Request::get($url)->send();
        return $response -> body;
    }
    public static function postJson($url, $data)
    {
      return self::_execReq($url,'POST',$data);
    }

    private static function _execReq($apiurl,$method,$body=null)
    {
        $url = $apiurl ;//"/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeid;//; kk.php.service";
        $req = \Httpful\Request::$method($url);
        if($body != null) {
            $sendStr = json_encode($body);
            $req = $req->body($sendStr);
        }
        $req->addHeader(
            "Accept",
            "application/json"
        );
        $res = $req ->send();
        return $res -> body;
    }
}
