<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CashTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //获取token
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/adminrequire', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);
        //
        //      dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        //
        //        //查询系统银行卡
        //        $response = $this->json('POST', '/api/user/getcashbanklist',array(
        //            "accessToken"=>$token,
        //        ));
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        $desbankid = $response->json()['data']['no'];
        //        dump('系统银行卡：');
        //        dump($desbankid);

        //查询用户银行卡
        //        $response = $this->json('POST', '/api/user/getbankcards',array(
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
        //        dump('用户银行卡');
        //        dump($response->json());
        //        if ($response->json()['data'] == null) {
        //            dump('用户没有绑定银行卡，开始绑定银行卡');
            //发送验证码
            $phone = '18645679959';
        //            $type = 'SLT02';
        //            $response = $this->json('POST', '/api/sms/sendcode',array(
        //                "accessToken"=>$token,
        //                "phone"=>$phone,
        //                "type"=>$type,
        //            ));
        //            $response
        //                ->assertStatus(200)
        //                ->assertJson([
        //                    'code' => 0,
        //                ]);
        //            dump($response->json()['data']);die;
            //绑定银行卡
        //            $bankType = 'B01';
        //            $bankNo = rand(1000000000000000,9999999999999999);
        //            $verfy = '337394';
        //            $response = $this->json('POST', '/api/user/addbankcard',array(
        //                "accessToken"=>$token,
        //                "bank_no"=>strval($bankNo),
        //                "bank_name"=>$name,
        //                "bank_type"=>$bankType,
        //                "phone"=>$phone,
        //                "verfy"=>$verfy,
        //            ));
        //            dump($response->json());die;
        //            $response
        //                ->assertStatus(200)
        //                ->assertJson([
        //                    'code' => 0,
        //                ]);
        //            dump('银行卡绑定成功，开始充值现金');
        //
        //            //查询用户银行卡
        //            $response = $this->json('POST', '/api/user/getbankcards',array(
        //                "accessToken"=>$token,
        //                "pageIndex"=>1,
        //                "pageSize"=>10
        //
        //            ));
        //            $response
        //                ->assertStatus(200)
        //                ->assertJson([
        //                    'code' => 0,
        //                ]);
        //            dump('用户银行卡');
        //
        //        }

        //        $bankid = $response->json()['data'][0]['no'];

        //充值
        //        $response = $this->json('POST','/api/cash/rechage',[
        //            "accessToken"=>$token,
        //            'amount'=>1000,
        //            'bankid'=>$bankid,
        //            'desbankid'=>$desbankid,
        //            'phone'=>13263463442
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('充值成功,单据号：');
        //        dump($response->json()['data']);
        //
        //审核充值成功
        // $no = "CR2017102621340012164";//$response->json()['data'];
        //        $response = $this->json('POST','/api/cash/rechargconfirm',[
        //            "accessToken"=>$token,
        //            'no'=>$no,
        //            'confirm'=>true,
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('审核成功');
        //        dump($response->json());
        //查询用户充值信息
        //        $response = $this->json('POST','/api/user/getrechargelist',array(
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>10
        //
        //        ));
        //
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户充值信息');
        //        dump($response->json());
        //
        //        //提现
        //        $response = $this->json('POST','/api/cash/withdrawal',[
        //            "accessToken"=>$token,
        //            'amount'=>500,
        //            'paypwd'=>'123456',
        //            'bankid'=>$bankid,
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('提现单据号：');
        //        $no = $response->json()['data'];
        //        dump($no);
        //
        //        //审核提现
        //        $response = $this->json('POST','/api/cash/withdrawalconfirm',[
        //            "accessToken"=>$token,
        //            'no'=>'CW2017032222210187851',
        //            'confirm'=>true,
        ////            'desbankid'=>$desbankid
        //        ]);
        //        dump($response->json());die;
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('审核成功');
        //        dump($response->json()['data']);die;
        //
        //        //查询用户提现信息
        //        $response = $this->json('POST','/api/user/getwithdrawallist',array(
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
        //        dump('用户提现信息');
        //        dump($response->json());
        //
        //
        //        $this->assertTrue(true);
    }

    protected function adminLogin($userid, $token, $pwd)
    {
        $response = $this->json(
            'POST', '/api/admin/login', array(
            "accessToken"=>$token,
            "userid"=>$userid,
            "pwd"=>$pwd
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
