<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class CoinSellTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //获取token
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

        //挂买单
        //        dump('开始挂买单');
        //        $count = 10;
        //        $price = 1;
        //        $type = 'kk04';
        //        $response = $this->json('POST', '/api/trade/transsell',[
        //            "accessToken"=>$token,
        //            "count"=>$count,
        //            "price"=>$price,
        //            "type"=>$type,
        //            "paypwd"=>1234567,
        //        ]);
        //
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        $no = $response->json()['data'];
        //        dump('挂买单成功，单据号：');
        //        dump($no);

        //        dump('查询所有卖单');
        //        $count = 10;
        //        $price = 1;
        //        $type = 'kk04';
        //        $response = $this->json('POST', '/api/trade/gettranactionsell',[
        //            "accessToken"=>$token,
        //            "pageIndex"=>1,
        //            "pageSize"=>"10",
        //        ]);
        //        //$response
        //         //   ->assertStatus(200)
        //       //     ->assertJson([
        //         //       'code' => 0,
        //        //    ]);
        //        dump($response->json());
        //        $no = $response->json()['data'];
        //        dump('卖单列表：');
        //        dump($no);
        //
        //        $response = $this->json('POST', '/api/user/getcashcoinvoucher',[
        //            "accessToken"=>$token,
        //            "coinType"=>$type,
        //        ]);
        //        dump($response->json());die;
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //
        //        $no = $response->json()['data'];
        //        dump('卖单列表：');
        //        dump($no);


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
        //        $response = $this->json('POST', '/api/trade/revoketranssell',[
        //            "accessToken"=>$token,
        //            "transactionSellNo"=>'TS2017032319291426482',
        //        ]);
        //        dump($response->json());die;
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
