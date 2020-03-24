<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SaveUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //获取token
               $response = $this->json('POST', '/api/auth/token/require', array());
               $response
                   ->assertStatus(200)
                   ->assertJson(
                       [
                       'code' => 0,
                       ]
                   );
               $token = $response->json()["data"]["accessToken"];
        
               dump("$token");
        
               //用户登陆
               $phone  = "13263463442";
               $pwd = "123456";
               $response = $this->json(
                   'POST', '/api/auth/mobilelogin', array(
                   "accessToken"=>$token,
                   "phone"=>$phone,
                    "verify"=>'KaKamfPwd8080'
        
                   )
               );
               $response
                   ->assertStatus(200);
        
               dump('登陆成功');
               dump($response->json());
        //
        //        //查询所有用户
        //        $response = $this->json('POST', '/api/admin/getuserlist',array(
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
        //        dump('用户:');
        //        dump($response->json());
        //
        //        //查询卖单时一些信息
        //        $response = $this->json('POST', '/api/trade/getsellorder',array(
        //            "accessToken"=>$token,
        //            "coinType"=>'kk03'
        //        ));
        //        dump($response->json());die;
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('用户:');
        //        dump($response->json());


        //发送验证码
        //            $phone = '13263463442';
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

        //修改新支付密码
        //        $response = $this->json('POST', '/api/auth/savepaypwd',array(
        //            "accessToken"=>$token,
        //            "phone"=>13263463442,
        //            "paypwd"=>1234567,
        //            "verfy"=>324657,
        //
        //        ));
        //        $response
        //            ->assertStatus(200)
        //            ->assertJson([
        //                'code' => 0,
        //            ]);
        //        dump('修改支付密码成功:');
        //        dump($response->json());

        // 修改新手机号
            //    $response = $this->json('POST', '/api/auth/savephone',array(
            //        "accessToken"=>$token,
            //        "phone"=>13263463442,
            //        "newPhone"=>18610891406,
            //        "verify"=>'KaKamfPwd8080',
        
            //    ));
            //    $response
            //        ->assertStatus(200);
            //    dump('修改手机号成功:');
            //    dump($response->json());



        $this->assertTrue(true);
    }
}
