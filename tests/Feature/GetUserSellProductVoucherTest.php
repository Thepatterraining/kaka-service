<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\FinanceBankData;
use App\Data\User\BankAccountData;
use App\Http\Adapter\Cash\FinanceBankAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;

class GetUserSellProductVoucherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetUserSellVoucher()
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
        // dump('正常登陆');
        // $user = '13263463444';
        // $pwd = '123qwe';
        // $user = $this->login($user,$token,$pwd);
        // dump($user);
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));
        // dump('用户id:'.$userid);

        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->mobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //开始查询列表
        dump('查询列表');
        $productNo = 'PRO2017090521142908509';
        $count = 8;
        $response = $this->getList($token, $productNo, $count);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(802006, $response['code']);

        //开始查询列表
        dump('查询列表');
        $productNo = 'PRO2017050514083412589';
        $count = 10;
        $response = $this->getList($token, $productNo, $count);
        dump($response);
        if (count($response) == 3) {
            $this->assertCount(3, $response);
            $this->assertEquals(802006, $response['code']);
        } else {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        

        //开始查询列表
        dump('查询列表');
        $productNo = 'PRO2017050514083412589';
        $count = 5;
        $response = $this->getList($token, $productNo, $count);
        dump($response);
        if (count($response) == 3) {
            $this->assertCount(3, $response);
            $this->assertEquals(802006, $response['code']);
        } else {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
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

    protected function getList($token, $productNo, $count)
    {
        $response = $this->json(
            'POST', '/api/user/buyproductvoucher', array(
            "accessToken"=>$token,
            "productNo"=>$productNo,
            "count"=>$count,
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
