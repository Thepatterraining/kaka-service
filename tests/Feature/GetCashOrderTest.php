<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetCashOrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCashOrder()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json(
            'POST', '/api/auth/token/require', [
            'appid' => 'F3452E02-AE64-A825-8C29-DFE5B2EA9C57',
            'appSecrect' => '9F7huqSentmOWddT',
            ]
        );
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);
        //登陆
        // dump('正常登陆');
        // $user = '13263463444';
        // $pwd = '123qwe';
        // $user = $this->login($user,$token,$pwd);
        // dump($user);
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));
        // dump('用户id:'.$userid);

        //开始登陆
        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->MobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //查询成交纪录
        dump('查询成交纪录：');
        $no = 'UCO2017111305393812358';
        $response = $this->getCashOrder($token, $no);
        dump($response);
        if (count($response) == 4) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        } else {
            $this->assertCount(3, $response);
            $this->assertEquals(880001, $response['code']);
        }
        


        //查询成交纪录
        dump('查询成交纪录：');
        $no = 2;
        $response = $this->getCashOrder($token, $no);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(880001, $response['code']);
    }

    protected function getCashOrder($token, $no)
    {
        $response = $this->json(
            'POST', '/api/user/getuserorderinfo', [
            "accessToken"=>$token,
            'no'=>$no,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function MobileLogin($phone, $token, $verify)
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
