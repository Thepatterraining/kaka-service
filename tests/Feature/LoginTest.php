<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //        //获取token
        //        $response = $this->json('POST', '/api/auth/token/require',array());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        $token = $response->json()["data"]["accessToken"];
        //
        //        dump("$token");

        //        //用户注册
        //        $pwd = "123456";
        //        $code = '13289012198';
        //        $data['loginid'] = 'emo';
        //        $data['nickname'] = 'emo';
        //        $data['mobile'] = 13263463442;
        //        $data['name'] = '周涛';
        //        $data['idno'] = '421126199803263816';
        //        $data['data'] = $data;
        //        $response = $this->json('POST', '/api/auth/reg',array(
        //            "accessToken"=>$token,
        //            "paypwd"=>1234567,
        //            "pwd"=>$pwd,
        //            "data"=>$data,
        //            "code"=>$code,
        //        ));
        //        dump($response->json());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        dump('注册成功');die;
        //
        //        //用户登陆
        //        $user  = "emo";
        //        $pwd = "123456";
        //        $response = $this->json('POST', '/api/auth/login',array(
        //            "accessToken"=>$token,
        //            "userid"=>$user,
        //            "pwd"=>$pwd
        //
        //        ));
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        dump('登陆成功');
        //        dump($response->json());
        //
        //        //查询用户现金账户
        //        $response = $this->json('POST', '/api/user/getusercashaccount',array(
        //            "accessToken"=>$token,
        //
        //        ));
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户现金账户:');
        //        dump($response->json());
        //
        //
        //        //查询用户现金账户
        //        $response = $this->json('POST', '/api/user/getvoucherinfo',array(
        //            "accessToken"=>$token,
        //            "price"=>1500,
        //            "sellNo"=>"sell_no"
        //        ));
        //
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户现金券:');
        //        dump($response->json());
        //
        //        //查询用户
        //        $response = $this->json('POST', '/api/admin/getitemlist',array(
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>10
        //        ));
        //        dump($response->json());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户现金券:');
        //        dump($response->json());
        //
        //
        //
        //        //查询现金券
        //        $response = $this->json('POST', '/api/user/getstorage',array(
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>10
        //
        //        ));
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户现金券:');
        //        dump($response->json());
        //
        //
        //
        //        $this->assertTrue(true);
    }
}
