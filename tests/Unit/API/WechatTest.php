<?php
namespace Tests\Unit\API;
use App\Data\API\Wechat\Wechat;
use App\Data\Auth\WechatMsg;
use Tests\TestCase;

class WechatTest extends TestCase
{

    
    public function testAccessTokenTests()
    {


        $wechat = new WechatMsg();

        $result = $wechat->SendAuthCode("oCWZVwDJLWRhn3uCu_Dhd0jJZgAY", "葛云飞", "登录");
        dump($result);

        $code = fgets(STDIN);
        dump($code);

        dump($wechat->CheckAuthCode("oCWZVwDJLWRhn3uCu_Dhd0jJZgAY", $result->item, $code));

        $open_id = "oCWZVwDJLWRhn3uCu_Dhd0jJZgAY";
        $wechat -> SaveReq($open_id, $result->item, "saasdd", ["haha"=>"12321","hoho"=>"dsds"]);
        /*
        dump($wechat->SendMsg("oCWZVwDJLWRhn3uCu_Dhd0jJZgAY","OxBoiaeRmYd2BAE529Ys9oGXeZy4OYUkPSEBgxVSU6Q",[
            "first"=>"你正在登录咔咔管理后台",
            "keyword1"=>"kaka",
            "keyword2"=>"01",
            "keyword3"=>"登录",
            "keyword4"=>"1234567",
            "keyword5"=>"过期不候",
            "remark"=>"咔咔要发,BUG要怼"
        ]));
            */

    }
}