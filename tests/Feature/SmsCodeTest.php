<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class SmsCodeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCashRecharge()
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

        // //登陆
        // dump('正常登陆');
        // $user = '13263463442';
        // $pwd = '123qwe';
        // $user = $this->login($user,$token,$pwd);
        // dump($user);
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));
        // dump('用户id:'.$userid);

        // //给用户添加代金券
        // dump('给用户添加代金券：');
        // $userid = 1;
        // $activity = 12345654321;
        // $response = $this->addvoucher($token,$userid,$activity);
        // $this->assertCount(3,$response);
        // $this->assertEquals(880001,$response['code']);
        // dump($response);


        // //给用户添加代金券
        // dump('给用户添加代金券：');
        // $userid = 199;
        // $activity = 'SA20170402193540899';
        // $response = $this->addvoucher($token,$userid,$activity);
        // $this->assertCount(3,$response);
        // $this->assertEquals(880001,$response['code']);
        // dump($response);

        // //给用户添加代金券
        // dump('给用户添加代金券：');
        // $userid = '199';
        // $activity = 'SA20170402193540898';
        // $response = $this->addvoucher($token,$userid,$activity);
        // dump($response);
        // $this->assertCount(4,$response);
        // $this->assertEquals(0,$response['code']);
    }

    protected function addvoucher($token, $userid, $activity)
    {
        $response = $this->json(
            'POST', '/api/admin/adduseractivity', [
            "accessToken"=>$token,
            'userid'=>$userid,
            'activity'=>$activity,
            ]
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
