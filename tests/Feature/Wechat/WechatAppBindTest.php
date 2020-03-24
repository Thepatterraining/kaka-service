<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class WechatAppBindTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testWechatAppBind()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        //微信用户绑定
        dump('微信用户绑定：');
        $openid = 'oql71w24Lx7OjqpvLsNKYqgQhgAs';
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        //        $data = '周涛';
        $response = $this->appBind($token, $openid, $appid, $data);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);


        //微信用户绑定
        dump('微信用户绑定：');
        $openid = 5;
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        $data['sex'] = '男';
        $response = $this->appBind($token, $openid, $appid, $data);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //微信用户绑定
        dump('微信用户绑定：');
        $openid = 5;
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        $data['sex'] = '男';
        $data['unionid'] = '8888';
        $response = $this->appBind($token, $openid, $appid, $data);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //微信用户绑定
        dump('微信用户绑定：');
        $openid = 5;
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        $data['sex'] = '男';
        $data['unionid'] = '345645';
        $response = $this->appBind($token, $openid, $appid, $data);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //微信用户绑定
        dump('微信用户绑定：');
        $openid = 345653423;
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        $data['sex'] = '男';
        $data['unionid'] = '9999';
        $response = $this->appBind($token, $openid, $appid, $data);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function appBind($token, $openid, $appid, $data = [])
    {
        $response = $this->json(
            'POST', '/api/wechat/appbind', [
            "accessToken"=>$token,
            'openid'=>$openid,
            'appid'=>$appid,
            'data'=>$data,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
