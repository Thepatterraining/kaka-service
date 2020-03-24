<?php 
namespace App\Data\Auth;


use App\Data\API\Wechat\Wechat;
use App\Data\Utils\DocNoMaker;
use Illuminate\Support\Facades\Redis;


/**
 * 微信验证码处理类
 *
 * @author  geyunfei@kakamf.com
 * @version 1.0
 * @date    Sep 25th,2017
 **/

class WechatMsg
{

    

    private $redis_seriakey = "WECHAT_AUTH";
    private $redis_intemkey = "WECHAT_INDEX";
    private $redis_reqkey = "WECHAT_REQ";
    

    

    /** 
     *  发送验证码
     **/
    public function SendAuthCode($openid,$username,$operation)
    {



        // 生成随机号
        $code = DocNoMaker::getRandomString(6, range(1, 9));
        // 生成序列号
        $index = DocNoMaker::getDateSeriaNoPre($this->redis_intemkey, 3);

        $tmp_id = config("wechat.checktmpid");
        $wechat= new Wechat();
        //存redis
        $key = $this->get_redis_key($index);
        Redis::command('set', [$key,$code]);
        Redis::command('expire', [$key,$this->get_redis_timeout()]);
        return (Object)
        [
            "result"=> $wechat->SendMsg(
                $openid, $tmp_id, [
                "first"=>"你正在进行后台管理操作",
                "keyword1"=>$username,
                "keyword2"=>$index,
                "keyword3"=>"{$operation}",
                "keyword4"=>(string)$code,
                "keyword5"=>"5分钟",
                "remark"=>"干活要精,开会要怼\r\n出品要浪,咔咔要发"
                ]
            ),
            "item"=>$index
            ];
        

    }


    private function get_redis_key($item)
    {
        return $this->redis_seriakey.$item;
    }

    private function get_redisreq_key($item)
    {
        return $this->redis_reqkey.$item;
    }

    private function get_redis_timeout()
    {
        return 5*60;
    }

    /** 
     * 校验验证码
     */
    public function CheckAuthCode($item,$checkcode)
    {
        $key = $this->get_redis_key($item);
        $savecode = Redis::command('get', [$key]);
        if ((int)$savecode == ((int)$checkcode)) {
            return  true;
        }
        return false;
    }


    /**
     * 保存请求
     */
    public function SaveReq($itemno,$url,$data)
    {

        $key  = $this->get_redisreq_key($itemno);
        $save_data = json_encode(["url"=>$url,"data"=>$data], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
        Redis::command('set', [$key,$save_data ]);
        Redis::command('expire', [$key,$this->get_redis_timeout()]);


    }

    /** 
     * 恢复请求
     **/
    public function GetReq($itemno)
    {

        $key  = $this->get_redisreq_key($itemno);
        $result =  json_decode(Redis::command('get', [$key]), true);
        Redis::command('del', [$key]);
        return $result;

    }


}