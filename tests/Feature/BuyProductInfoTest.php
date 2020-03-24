<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class BuyProductInfoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddProductInfo()
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

        //开始登陆
        dump('手机号登陆');
        $phone = '18645679959';
        $verify = 'KaKamfPwd8080';
        $paypwd = '123qweA';
        $response = $this->MobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //开始购买产品
        dump('开始购买产品');
        $productData = new \App\Data\Product\InfoData;
        $where['product_status'] = \App\Data\Product\InfoData::$PRODUCT_STATUS_ON_SALE;
        $product = $productData->find($where);
        if (!empty($product)) {
            // $no = $product->product_no;
            $no = 'PRO2017092522150070788';
            dump($no);
            $count = 67;
            $voucherNo = '';
            $response = $this->buy($token, $no, $count, $paypwd, $voucherNo);
            dump($response);
            // $this->assertCount(3, $response);
            // $this->assertEquals(802006, $response['code']);

            //开始购买产品
            // dump('开始购买产品');
            // $no = 'PRO2017050921314213214';
            // $count = 10;
            // $response = $this->buyProduct($token,$no,$count,$paypwd);
            // dump($response);
            // $this->assertCount(4,$response);
            // $this->assertEquals(0,$response['code']);

            //开始购买产品
            // dump('开始购买产品');
            // $no = 'PRO2017051712051590100';
            // $count = 3;
            // $voucehrNo = '';
            // $response = $this->buy($token, $no, $count, $paypwd, $voucehrNo);
            // dump($response);
            // if (count($response) == 3) {
            //     $this->assertCount(3, $response);
            //     $this->assertEquals(802006, $response['code']);
            // } else {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // }
            

            //开始购买产品
            // dump('开始购买产品');
            // $no = 'PRO2017052107360933823';
            // $count = 1;
            // $voucherNo = 'VCS2017081017044810142';
            // $response = $this->buy($token, $no, $count, $paypwd, 'VCS2017081017044810142');
            // dump($response);
            // if (count($response) == 3) {
            //     $this->assertCount(3, $response);
            //     // $this->assertEquals(802006, $response['code']);
            // } else {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // }

            // //开始购买产品
            // dump('开始购买产品');
            // // $no = 'PRO2017050316265700481';
            // $count = 2;
            // $voucherNo = 'VCS2017040601523364971';
            // $response = $this->buy($token, $no, $count, $paypwd, $voucherNo);
            // dump($response);
            // if (count($response) == 3) {
            //     $this->assertCount(3, $response);
            //     // $this->assertEquals(802006, $response['code']);
            // } else {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // }dump('开始购买产品');
            // $no = 'PRO2017052107360933823';
            // $count = 1;
            // $voucherNo = 'VCS2017081017044810142';
            // $response = $this->buy($token, $no, $count, $paypwd, 'VCS2017081017044810142');
            // dump($response);
            // if (count($response) == 3) {
            //     $this->assertCount(3, $response);
            //     // $this->assertEquals(802006, $response['code']);
            // } else {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // }

            // //开始购买产品
            // dump('开始购买产品');
            // // $no = 'PRO2017050316265700481';
            // $count = 2;
            // $voucherNo = 'VCS2017040601523364971';
            // $response = $this->buy($token, $no, $count, $paypwd, $voucherNo);
            // dump($response);
            // if (count($response) == 3) {
            //     $this->assertCount(3, $response);
            //     // $this->assertEquals(802006, $response['code']);
            // } else {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // }
        }
        
    }

    protected function buy($token, $no, $count, $paypwd, $voucherNo = '')
    {
        dump($voucherNo);
        $response = $this->json(
            'POST', '/api/product/buyproduct', array(
            "accessToken"=>$token,
            "no"=>$no,
            "count"=>$count,
            "voucherNo"=>$voucherNo,
            "paypwd"=>$paypwd
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function buyProduct($token, $no, $count, $paypwd)
    {
        $response = $this->json(
            'POST', '/api/product/buyproduct', array(
            "accessToken"=>$token,
            "no"=>$no,
            "count"=>$count,
            "paypwd"=>$paypwd,
            )
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
