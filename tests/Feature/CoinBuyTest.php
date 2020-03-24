<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoinBuyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
               //获取token
            //    $response = $this->json('POST', '/api/auth/token/require',array());
            //    $response
            //        ->assertStatus(200)
            //        ->assertJson([
            //            'code' => 0,
            //        ]);
            //    $token = $response->json()["data"]["accessToken"];
        
            //    dump("$token");
        
            //    //用户登陆
            //    $phone  = "13263463442";
            //    $verify = "KaKamfPwd8080";
            //    $response = $this->json('POST', '/api/auth/mobilelogin',array(
            //        "accessToken"=>$token,
            //        "phone"=>$phone,
            //        "verify"=>$verify
        
            //    ));
            //    dump($response->json());
            //    $response
            //        ->assertStatus(200)
            //        ->assertJson([
            //            'code' => 0,
            //        ]);
        
            //    dump('登陆成功');
               

        //挂买单
            //    dump('开始挂买单');
            //    $count = 10;
            //    $price = 1;
            //    $type = 'kk04';
            //    $response = $this->json('POST', '/api/trade/transbuy',[
            //        "accessToken"=>$token,
            //        "count"=>$count,
            //        "price"=>$price,
            //        "type"=>$type,
            //        "paypwd"=>123456,
            //        "voucherNo"=>'VCN2017031915460142476'
            //    ]);
            //    dump($response->json());
            //    $response
            //        ->assertStatus(200)
            //        ->assertJson([
            //            'code' => 0,
            //        ]);
        
            //    $no = $response->json()['data'];
            //    dump('挂买单成功，单据号：');
            //    dump($no);

        //        dump('查询所有卖单');
        //        $count = 10;
        //        $price = 1;
        //        $type = 'kk04';
        //        $response = $this->json('POST', '/api/admin/getusercoinjournal',[
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>"10",
        //        ]);
        //        dump($response->json());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        $no = $response->json()['data'];
        //        dump('挂买单成功，单据号：');
        //        dump($no);die;
        //
        //        dump('开始挂买单');
        //        $count = 10;
        //        $price = 1;
        //        $type = 'kk04';
        //        $response = $this->json('POST', '/api/trade/transbuysell',[
        //            "accessToken"=>$token,
        //            "count"=>$count,
        //            "no"=>"1111",
        //            "paypwd"=>123456,
        //            "voucherNo"=>'null'
        //        ]);
        //        dump($response->json());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        $no = $response->json()['data'];
        //        dump('挂买单成功，单据号：');
        //        dump($no);

        //撤销买单
        //        dump('撤销买单');
        //        $response = $this->json('POST', '/api/trade/revoketransbuy',[
        //            "accessToken"=>$token,
        //            "transactionBuyNo"=>$no,
        //        ]);
        //        dump($response->json());
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('撤销成功');
        //        dump($response->json()['data']);

        //查看买单
        //        dump('查询我的买单列表');
        //        $response = $this->json('POST', '/api/user/gettranactionbuy',[
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>10,
        //        ]);
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        dump($response->json()['data']);
        //
        //
        //        $this->assertTrue(true);
    }
}
