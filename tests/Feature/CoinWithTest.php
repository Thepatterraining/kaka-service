<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoinWithTest extends TestCase
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
        //        $name = $response->json()['data']['name'];
        //        dump('登陆成功');
        //
        //        //提现代币
        //        $coinType = 'kk03';
        //        $response = $this->json('POST','/api/coin/withdrawal',[
        //            "accessToken"=>$token,
        //            "coin_type"=>$coinType,
        //            "userid"=>56,
        //            "amount"=>2,
        //            "address"=>'66666666666',
        //            "paypwd"=>123456
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('提现代币单据号：');
        //        $no = $response->json()['data'];
        //        dump($no);
        //
        //        //提现代币审核
        //        $response = $this->json('POST','/api/coin/withdrawalconfirm',[
        //            "accessToken"=>$token,
        //            "no"=>$no,
        //            "confirm"=>true
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('提现代币审核成功：');
        //        dump($response->json()['data']);
        //
        //        //查询用户提现代币信息
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
        //        dump('用户代币充值信息');
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
        //        $this->assertTrue(true);
    }
}
