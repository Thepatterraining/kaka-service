<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class WechatGetUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testWechatGetUser()
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


        //查询微信用户
        dump('查询微信用户：');
        $userid = 262;
        $appid = 'wxe5ffb035e97a61b9';
        $response = $this->getUserInfo($token, $userid, $appid);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);


        //查询微信用户
        dump('查询微信用户：');
        $userid = 'oql71w7VSIgRLievZsW4Fdfikpo8';
        $appid = 'wx131f45fbf860026f';
        $response = $this->getUserInfo2($token, $userid, $appid);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //查询微信用户
        dump('查询微信用户：');
        $userid = '262';
        $appid = 'wx131f45fbf860026f';
        $response = $this->getUserInfo3($token, $userid, $appid);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(880001, $response['code']);

        //查询微信用户
        dump('查询微信用户：');
        $userid = 262;
        $appid = 'wxe5ffb035e97a61b9';
        $openid = 'oql71w7VSIgRLievZsW4Fdfikpo8';
        $response = $this->getUserInfo4($token, $userid, $openid, $appid);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //查询微信用户
        dump('查询微信用户：');
        $appid = 'wxe5ffb035e97a61b9';
        $unionid = 'owPDKvxODfzp9X6saOFZlBdBaAPc';
        $response = $this->getUserInfo5($token, $unionid, $appid);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function getUserInfo($token, $userid, $appid)
    {
        $response = $this->json(
            'POST', '/api/wechat/getuserinfo', [
            "accessToken"=>$token,
            'userid'=>$userid,
            'appid'=>$appid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserInfo2($token, $userid, $appid)
    {
        $response = $this->json(
            'POST', '/api/wechat/getuserinfo', [
            "accessToken"=>$token,
            'openid'=>$userid,
            'appid'=>$appid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserInfo3($token, $userid, $appid)
    {
        $response = $this->json(
            'POST', '/api/wechat/getuserinfo', [
            "accessToken"=>$token,
            //            'openid'=>$userid,
            'appid'=>$appid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserInfo4($token, $userid, $openid, $appid)
    {
        $response = $this->json(
            'POST', '/api/wechat/getuserinfo', [
            "accessToken"=>$token,
            'openid'=>$openid,
            'userid'=>$userid,
            'appid'=>$appid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserInfo5($token, $unionid, $appid)
    {
        $response = $this->json(
            'POST', '/api/wechat/getuserinfo', [
            "accessToken"=>$token,
            'unionid'=>$unionid,
            'appid'=>$appid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
