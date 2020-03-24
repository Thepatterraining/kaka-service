<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class WechatAppLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testWechatAppLogin()
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

        //登陆
        //    dump('正常登陆');
        //    $user = '13263463442';
        //    $pwd = '123qwe';
        //    $user = $this->login($user,$token,$pwd);
        //    dump($user);
        //    $this->assertCount(4,$user);
        //    $userid = $user['data']['id'];
        //    $this->assertTrue(is_numeric($userid));
        //    dump('用户id:'.$userid);

        // dump('手机号登陆');
        // $phone = '13263463442';
        // $verify = 'KaKamfPwd8080';
        // $response = $this->mobileLogin($phone, $token, $verify);
        // dump($response);
        // $this->assertCount(4, $response);
        // $this->assertEquals(0, $response['code']);

        //微信用户登陆
        dump('微信用户登陆：');
        $openid = 'oql71w24Lx7OjqpvLsNKYqgQhgAs';
        $appid = 'wx131f45fbf860026f';
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $data['nickname'] = '周涛';
        $response = $this->appLogin($token, $openid, $appid, $phone, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);


        //微信用户登陆
        dump('微信用户登陆：');
        $openid = 5;
        $appid = 'wx131f45fbf860026f';
        $data['nickname'] = '周涛';
        $data['sex'] = '男';
        $response = $this->appLogin($token, $openid, $appid, $phone, $verify);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }
    protected function mobileLogin($phone, $token, $verify)
    {
        $response = $this->json(
            'POST', '/api/auth/mobilelogin', array(
            "accessToken"=>$token,
            "phone"=>$phone,
            "verify"=>$verify
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function appLogin($token, $openid, $appid, $phone, $verify, $data = [])
    {
        $response = $this->json(
            'POST', '/api/wechat/applogin', [
            "accessToken"=>$token,
            'openid'=>$openid,
            'appid'=>$appid,
            'phone'=>$phone,
            'verify'=>$verify,
            'data'=>$data,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
    protected function login($user, $token, $pwd, $type = false)
    {
        //用户登陆
        //        $user  = 'kk970645';
        $response = $this->json(
            'POST', '/api/auth/login', array(
            "accessToken"=>$token,
            "userid"=>$user,
            "pwd"=>$pwd
            )
        );
        $response->assertStatus(200);
        return $response->json();
        $name = $response->json();
        dump('登陆成功');
        //        if ($type == 1) {
        dump($response->json());
        return $response->json()['data']['id'];
        //        }
        if ($type == false) {
            //            $user = $this->getUser($token);
            //            return $this->login($user,$token,1);
        }
    }
    protected function getUser($token)
    {
        $pageIndex = rand(1, 10);
        $pageSize = rand(10, 12);
        $index = rand(1, 9);
        $response = $this->json(
            'POST', '/api/admin/getuserlist', [
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize,
            ]
        );
        $response
            ->assertStatus(200)
            ->assertJson(
                [
                'code' => 0,
                ]
            );
        $user = $response->json()['data']['items'][$index]['user'];
        return $user;
    }
}
