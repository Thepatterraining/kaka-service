<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoinRechargeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCoinRecharge()
    {
        // dump('测试开始');
        // dump("Require Token:");
        // $response = $this->json('POST', '/api/auth/token/require',array());
        // $response->assertStatus(200);
        // $this->assertEquals(4,count($response->json()));
        // $this->assertEquals(2,count($response->json()["data"]));
        // $this->assertEquals(0,$response->json()['code']);
        // $token = $response->json()["data"]["accessToken"];

        // dump($token);

        // // //登陆
        // // dump('不存在用户登陆');
        // // $user = '666666';
        // // $pwd = '123qwe';
        // // $user = $this->login($user,$token,$pwd);
        // // $this->assertCount(3,$user);
        // // $this->assertEquals(880001,$user['code']);


        // // //模拟用户登陆密码错误
        // // dump('用户登陆密码错误');
        // // $user = '13263463442';
        // // $pwd = '12345qwe';
        // // $user = $this->login($user,$token,$pwd);
        // // $this->assertCount(3,$user);
        // // $this->assertEquals(880001,$user['code']);

        // // //登陆
        // // dump('正常登陆');
        // // $user = '13263463442';
        // // $pwd = '123qwe';
        // // $user = $this->login($user,$token,$pwd);
        // // dump($user);
        // // $this->assertCount(4,$user);
        // // $userid = $user['data']['id'];
        // // $this->assertTrue(is_numeric($userid));
        // // dump('用户id:'.$userid);

        // //开始登陆
        // dump('手机号登陆');
        // $phone = '13263463442';
        // $verify = 'KaKamfPwd8080';
        // $response = $this->mobileLogin($phone,$token,$verify);
        // dump($response);
        // $this->assertCount(4,$response);
        // $this->assertEquals(0,$response['code']);

        // //查询系统银行
        // dump('系统银行：');
        // $sysBank = $this->getSysBank($token);
        // $bankIndex = rand(0,count($sysBank) - 1);
        // $this->assertCount(2,$sysBank['data'][$bankIndex]);
        // $sysBankType = $sysBank['data'][$bankIndex]['no'];
        // dump($sysBankType);

        // //查询系统银行卡
        // $sysBankNo = $this->getSysBankNo($token);
        // dump($sysBankNo);
        // $this->assertCount(4,$sysBankNo);
        // $this->assertCount(8,$sysBankNo['data']);
        // $desbankid = $sysBankNo['data']['no'];
        // dump('系统银行卡：'.$desbankid);

        // //查询用户银行卡
        // dump('用户银行卡');
        // $pageIndex = 1;
        // $pageSize = 10;
        // $bankid = $this->getUserBank($token,$pageIndex,$pageSize);
        // $this->assertCount(4,$bankid);
        // $this->assertInternalType('array',$bankid['data']);
        // if (count($bankid['data']) == 0) {
        //     dump('绑定银行卡 name是数字时候');
        //     //绑定银行卡
        //     $name = 45345;
        //     $phone = 13263463442;
        //     $bankNo = rand(1000000000000000,9999999999999999);
        //     $bankid = $this->addUserBank($token,$sysBankType,$bankNo,$phone,$name);
        //     $this->assertEquals(880001,$bankid['code']);
        //     $this->assertCount(3,$bankid);


        //     dump('绑定银行卡 银行卡号小于15位的时候');
        //     //绑定银行卡
        //     $name = '太阳宫支行';
        //     $phone = '13263463442';
        //     $bankNo = rand(0,999999999999999);
        //     $bankid = $this->addUserBank($token,$sysBankType,$bankNo,$phone,$name);
        //     $this->assertEquals(880001,$bankid['code']);
        //     $this->assertCount(3,$bankid);


        //     dump('绑定银行卡');
        //     //绑定银行卡
        //     $name = '太阳宫支行';
        //     $phone = 13263463442;
        //     $bankNo = rand(1000,9999).rand(1000,9999).rand(1000,9999).rand(1000,9999999);
        //     $bankid = $this->addUserBank($token,$sysBankType,$bankNo,$phone,$name);
        //     $this->assertCount(4,$bankid);
        //     $this->assertEquals(0,$bankid['code']);
        //     $this->assertEquals($userid,$bankid['data']['account_userid']);
        //     $this->assertEquals($bankNo,$bankid['data']['account_no']);
        //     dump('银行卡号:'.$bankNo);
        //     $bankid = $bankNo;
        // } else {
        //     if (rand(0,1)) {
        //         dump('绑定银行卡');
        //         //绑定银行卡
        //         $name = '太阳宫支行';
        //         $phone = 13263463442;
        //         $bankNo = rand(1000,9999).rand(1000,9999).rand(1000,9999).rand(1000,9999999);
        //         $bankid = $this->addUserBank($token,$sysBankType,$bankNo,$phone,$name);
        //         dump($bankid);
        //         $this->assertCount(4,$bankid);
        //         $this->assertEquals(0,$bankid['code']);
        //         $this->assertEquals($userid,$bankid['data']['account_userid']);
        //         $this->assertEquals($bankNo,$bankid['data']['account_no']);
        //         dump('银行卡号:'.$bankNo);
        //         $bankid = $bankNo;
        //     } else {
        //         $bankid = $bankid['data'][0]['no'];
        //     }
        // }
        // dump('用户银行卡'.$bankid);


        // //充值
        // dump('充值手机号错误：');
        // $amount = rand(0,9999);
        // dump('充值金额：'.$amount);
        // $phone = 13263463443;
        // $rachargeNo = $this->racharge($token,$bankid,$desbankid,$phone,$amount);
        // $this->assertCount(3,$rachargeNo);
        // $this->assertEquals(801015,$rachargeNo['code']);


        // //充值
        // dump('充值小金额');
        // $amount = rand(0,9999);
        // dump('充值金额：'.$amount);
        // $phone = 13263463442;
        // $rachargeNo = $this->racharge($token,$bankid,$desbankid,$phone,$amount);
        // $this->assertCount(4,$rachargeNo);
        // $this->assertEquals(0,$rachargeNo['code']);


        // //充值
        // dump('充值小数');
        // $amount = rand(0,9999) . '.' . rand(0,9999);
        // dump('充值金额：'.$amount);
        // $phone = 13263463442;
        // $rachargeNo = $this->racharge($token,$bankid,$desbankid,$phone,$amount);
        // $this->assertCount(4,$rachargeNo);
        // $this->assertEquals(0,$rachargeNo['code']);


        // //充值
        // $amount = rand(10000,99999);
        // dump('充值金额：'.$amount);
        // $phone = 13263463442;
        // $rachargeNo = $this->racharge($token,$bankid,$desbankid,$phone,$amount);
        // $this->assertCount(4,$rachargeNo);
        // $this->assertEquals(0,$rachargeNo['code']);
        // dump($rachargeNo);
    }

    protected function racharge($token, $bankid, $desbankid, $phone, $amount)
    {
        $response = $this->json(
            'POST', '/api/cash/rechage', [
            "accessToken"=>$token,
            'amount'=>$amount,
            'bankid'=>$bankid,
            'desbankid'=>$desbankid,
            'phone'=>$phone
            ]
        );
        $response->assertStatus(200);
        return $response->json();
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

    protected function getSysBankNo($token)
    {
        $response = $this->json(
            'POST', '/api/user/getcashbanklist', array(
            "accessToken"=>$token,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function addUserBank($token, $sysBankType, $bankNo, $phone, $name)
    {
        $bankType = $sysBankType;
        $verfy = 'KaKamfPwd8080';
        $response = $this->json(
            'POST', '/api/user/addbankcard', array(
            "accessToken"=>$token,
            "bank_no"=>$bankNo,
            "bank_name"=>$name,
            "bank_type"=>$bankType,
            "phone"=>$phone,
            "verfy"=>$verfy,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getSysBank($token)
    {
        $response = $this->json(
            'POST', '/api/dic/getbanks', array(
            "accessToken"=>$token,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserBank($token, $pageIndex, $pageSize)
    {
        $response = $this->json(
            'POST', '/api/user/getbankcards', array(
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize

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
