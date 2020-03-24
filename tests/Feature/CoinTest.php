<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoinTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //        //获取token
        //        dump("Require Token:");
        //        $response = $this->json('POST', '/api/auth/token/require',array());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        $token = $response->json()["data"]["accessToken"];
        //
        //        dump("$token");
        //
        //        //用户登陆
        //        $user  = "kk142872";
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
        //
        //        //查询用户充值代币信息
        //        $response = $this->json('POST', '/api/user/getcoinrechargelist',array(
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
        //        dump('用户代币充值信息');
        //        dump($response->json());
        //
        //        //查询管理员充值代币信息
        //        $response = $this->json('POST', '/api/admin/getrechargelist',array(
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
        //        dump('所有代币充值信息');
        //        dump($response->json());
        //
        //
        //        //查询用户充值代币信息
        //        $response = $this->json('POST', '/api/user/getcoinwithdrawallist',array(
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
        //        dump('用户代币提现信息');
        //        dump($response->json());
        //
        //
        //        //查询用户充值代币信息
        //        $response = $this->json('POST', '/api/admin/getwithdrawallist',array(
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
        //        dump('所有代币提现信息');
        //        dump($response->json());
        //
        //
        //        //查询用户充值代币信息
        //        $response = $this->json('POST', '/api/user/getcoinjournallist',array(
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
        //        dump('用户代币流水信息');
        //        dump($response->json());
        //
        //        //查询用户代币账户
        //        $response = $this->json('POST', '/api/user/getusercoinlist',array(
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
        //        dump('用户代币账户:');
        //        dump($response->json());
        //
        //
        //        $this->assertTrue(true);
    }
}
