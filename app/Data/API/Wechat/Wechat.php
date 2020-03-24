<?php
namespace App\Data\API\Wechat;
use App\Data\API\Wechat\IWechat ;
use App\Data\API\Utils\HttpUtils;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
class Wechat implements IWechat
{


    private $appid;
    private $appsecret;
    private $redis_key;
    public function SendMsg($openid,$msg_tmpid,$msg_content)
    {
        $accessToken = $this->get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";

        $sendMsg = [
            "touser"=>$openid,
            "template_id"=>$msg_tmpid,
            "data"=>[]
        ];
        foreach($msg_content as $key=>$value)
        {
            $sendMsg ["data"][$key]=[
                "value"=>$value
            ];
        }

        $result = HttpUtils::postJson($url, $sendMsg);
        if($result->errcode !=0) {

            $accessToken = $this->get_access_token(true);
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken}";
            Log::info(json_encode($result, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK));
            $result = HttpUtils::postJson($url, $sendMsg);

        }
        return $result->errcode ==0;

    }   
    public  function get_access_token($force = false)
    {
        if($force == false ) {

            $accessToken = Redis::command('get', [$this->redis_key]);
            if ($accessToken != null) {
                return $accessToken;
            }
        } 
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
        $res =  HttpUtils::getJson($url);
        Redis::command('set', [$this->redis_key,$res->access_token]);
        Redis::command('expire', [$this->redis_key,$res->expires_in-600]);
        return $res->access_token;
    } 

    function __construct()
    {
        $this->appid = config("wechat.appid");
        $this->appsecret = config("wechat.secret");
        $this->redis_key = "php_wx_token_".$this->appid;
    }
}